<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

class PengirimanController extends Controller
{
    public function index()
    {
        $pengiriman = DB::table('tb_pengiriman')
            ->join('tb_transaksi', 'tb_pengiriman.transaksi_id', '=', 'tb_transaksi.transaksi_id')
            ->join('tb_mobil', 'tb_transaksi.mobil_id', '=', 'tb_mobil.mobil_id')
            ->select('tb_pengiriman.*', 'tb_mobil.nama_mobil', 'tb_transaksi.total_harga')
            ->get();

        return view('pengiriman.index', compact('pengiriman'));
    }

    public function updateStatus($id, $status)
    {
        DB::table('tb_pengiriman')->where('pengiriman_id', $id)->update([
            'status_pengiriman' => $status,
            'updated_at' => now(),
        ]);

        return back()->with('success', 'Status pengiriman berhasil diperbarui!');
    }
}
