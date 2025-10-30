<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Models\Mobil;

class CarController extends Controller
{
    public function show($id)
    {
        $mobil = Mobil::findOrFail($id);
        return view('car_detail', compact('mobil'));
    }

    public function orderPage()
    {
        // Misal Porsche 911 itu mobil_id = 1
        return redirect()->route('configure', ['id' => 1]);
    }
}
