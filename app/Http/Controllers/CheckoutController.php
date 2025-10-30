<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Midtrans\Config;
use Midtrans\Snap;

class CheckoutController extends Controller
{
    // ==================================================
    // 🔹 Halaman Konfigurasi Mobil (per mobil berbeda)
    // ==================================================
    public function configure($id)
    {
        // Ambil data mobil dari database
        $mobil = DB::table('tb_mobil')->where('mobil_id', $id)->first();

        if (!$mobil) {
            abort(404, 'Mobil tidak ditemukan.');
        }

        // Mapping ID mobil ke file view-nya
        $viewMap = [
            1 => 'car.configure_911',
            2 => 'car.configure_cayenne',
            3 => 'car.configure_panamera',
            // tambahkan lagi jika nanti ada mobil baru
        ];

        // Cek apakah ID ada di daftar viewMap
        if (array_key_exists($id, $viewMap) && view()->exists($viewMap[$id])) {
            return view($viewMap[$id], compact('mobil'));
        }

        // Kalau tidak ditemukan view-nya, tampilkan error 404
        abort(404, 'Halaman konfigurasi belum dibuat untuk mobil ini.');
    }

    // ==================================================
    // 🆕 🔹 Proses Continue dari halaman konfigurasi mobil
    // ==================================================
    public function continueCheckout(Request $request)
    {
        $user = Auth::user();
        if (!$user) {
            return redirect('/login')->with('error', 'Silakan login terlebih dahulu.');
        }

        $request->validate([
            'mobil_id' => 'required|integer',
            'warna' => 'required|string',
            'transmisi' => 'required|string',
        ]);

        // Ambil data mobil
        $mobil = DB::table('tb_mobil')->where('mobil_id', $request->mobil_id)->first();
        if (!$mobil) {
            return back()->with('error', 'Mobil tidak ditemukan.');
        }

        // Simpan konfigurasi sementara di session
        session([
            'konfigurasi_mobil' => [
                'mobil_id' => $mobil->mobil_id,
                'nama_mobil' => $mobil->nama_mobil,
                'warna' => $request->warna,
                'transmisi' => $request->transmisi,
                'harga' => $mobil->harga,
            ]
        ]);

        return redirect()->route('checkout.index', ['mobil_id' => $mobil->mobil_id]);
    }

    // ==================================================
    // 🔹 Menampilkan halaman checkout
    // ==================================================
    public function index($mobil_id)
    {
        $mobil = DB::table('tb_mobil')->where('mobil_id', $mobil_id)->first();
        if (!$mobil) {
            abort(404, 'Mobil tidak ditemukan.');
        }

        $user = Auth::user();
        if (!$user) {
            return redirect('/login')->with('error', 'Silakan login terlebih dahulu.');
        }

        $alamat = DB::table('tb_alamat')->where('user_id', $user->user_id)->get();
        if ($alamat->isEmpty()) {
            return redirect()->route('alamat.create')->with('warning', 'Tambahkan alamat sebelum checkout.');
        }

        // Ambil data konfigurasi dari session
        $konfigurasi = session('konfigurasi_mobil');

        return view('checkout.index', compact('mobil', 'user', 'alamat', 'konfigurasi'));
    }

    // ==================================================
    // 🔹 Proses Checkout dan Payment Midtrans
    // ==================================================
    public function store(Request $request)
    {
        $user = Auth::user();
        if (!$user) {
            return redirect('/login')->with('error', 'Silakan login terlebih dahulu.');
        }

        $request->validate([
            'mobil_id' => 'required|integer',
            'alamat_id' => 'required|integer',
        ]);

        $mobil = DB::table('tb_mobil')->where('mobil_id', $request->mobil_id)->first();
        if (!$mobil) {
            return back()->with('error', 'Mobil tidak ditemukan.');
        }

        // Ambil data konfigurasi dari session
        $config = session('konfigurasi_mobil');
        $warna = $config['warna'] ?? 'default';
        $transmisi = $config['transmisi'] ?? '-';

        $total = $mobil->harga;

        // 1️⃣ Simpan data transaksi
        $transaksi_id = DB::table('tb_transaksi')->insertGetId([
            'user_id' => $user->user_id,
            'mobil_id' => $mobil->mobil_id,
            'alamat_id' => $request->alamat_id,
            'tanggal_transaksi' => now(),
            'status_transaksi' => 'pending',
            'total_harga' => $total,
            'warna' => $warna,
            'transmisi' => $transmisi,
            'created_at' => now(),
        ]);

        // 2️⃣ Midtrans
        Config::$serverKey = config('midtrans.server_key');
        Config::$isProduction = false;
        Config::$isSanitized = true;
        Config::$is3ds = true;

        $orderId = 'INV-' . strtoupper(uniqid());

        $params = [
            'transaction_details' => [
                'order_id' => $orderId,
                'gross_amount' => $total,
            ],
            'customer_details' => [
                'first_name' => $user->nama,
                'email' => $user->email,
                'phone' => $user->no_hp,
            ],
            'item_details' => [
                [
                    'id' => $mobil->mobil_id,
                    'price' => $mobil->harga,
                    'quantity' => 1,
                    'name' => $mobil->nama_mobil . " ($warna, $transmisi)",
                ]
            ]
        ];

        $snapToken = Snap::getSnapToken($params);

        // 3️⃣ Simpan pembayaran
        DB::table('tb_pembayaran')->insert([
            'transaksi_id' => $transaksi_id,
            'metode_pembayaran' => 'Midtrans QRIS',
            'jumlah' => $total,
            'status_pembayaran' => 'pending',
            'snap_token' => $snapToken,
            'created_at' => now(),
        ]);

        // 4️⃣ Buat data pengiriman awal
        DB::table('tb_pengiriman')->insert([
            'transaksi_id' => $transaksi_id,
            'kurir' => 'Porsche Logistics',
            'no_resi' => 'PRC-' . strtoupper(uniqid()),
            'status_pengiriman' => 'diproses',
            'tanggal_dikirim' => null,
            'tanggal_sampai' => null,
            'created_at' => now(),
        ]);

        return view('checkout.payment', compact('snapToken', 'mobil', 'total'));
    }

    // ==================================================
    // 🔹 Callback Midtrans (update status)
    // ==================================================
    public function callback(Request $request)
    {
        $serverKey = config('midtrans.server_key');
        $hashed = hash("sha512", $request->order_id . $request->status_code . $request->gross_amount . $serverKey);

        if ($hashed !== $request->signature_key) {
            return response()->json(['message' => 'Invalid signature'], 403);
        }

        $status = $request->transaction_status;
        $transaksi = DB::table('tb_transaksi')->where('transaksi_id', $request->order_id)->first();

        if (!$transaksi) {
            return response()->json(['message' => 'Transaksi tidak ditemukan'], 404);
        }

        if (in_array($status, ['capture', 'settlement'])) {
            DB::table('tb_transaksi')
                ->where('transaksi_id', $transaksi->transaksi_id)
                ->update(['status_transaksi' => 'selesai']);

            DB::table('tb_pembayaran')
                ->where('transaksi_id', $transaksi->transaksi_id)
                ->update(['status_pembayaran' => 'berhasil']);

            DB::table('tb_pengiriman')
                ->where('transaksi_id', $transaksi->transaksi_id)
                ->update(['status_pengiriman' => 'dikirim', 'tanggal_dikirim' => now()]);
        } elseif ($status == 'pending') {
            DB::table('tb_pembayaran')
                ->where('transaksi_id', $transaksi->transaksi_id)
                ->update(['status_pembayaran' => 'pending']);
        } elseif (in_array($status, ['deny', 'cancel', 'expire'])) {
            DB::table('tb_transaksi')
                ->where('transaksi_id', $transaksi->transaksi_id)
                ->update(['status_transaksi' => 'gagal']);

            DB::table('tb_pembayaran')
                ->where('transaksi_id', $transaksi->transaksi_id)
                ->update(['status_pembayaran' => 'gagal']);
        }

        return response()->json(['message' => 'Callback processed']);
    }
}
