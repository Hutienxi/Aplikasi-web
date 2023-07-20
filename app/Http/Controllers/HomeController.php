<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\BarangKeluar;
use App\Models\BarangMasuk;
use App\Models\User;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $dataBarang = Barang::count();
        $barangMasuk = BarangMasuk::count();
        $barangKeluar = BarangKeluar::count();
        $user = User::count();
        return view('home', compact('dataBarang', 'barangMasuk', 'barangKeluar', 'user'));
    }
}
