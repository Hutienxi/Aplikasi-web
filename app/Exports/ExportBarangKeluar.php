<?php

namespace App\Exports;

use DB;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class ExportBarangKeluar implements FromView, ShouldAutoSize
{
   /**
     * @return \Illuminate\Support\Collection
     */
    public function view(): View
    {

        $startDate = request()->input('startDate');

        $endDate = request()->input('endDate');

        $data = DB::table('barang_keluar')
                ->select('id_barang', DB::raw('sum(qty) as totalJual'), 'tanggal')
                // ->leftJoin('barangs', 'barangs.id', 'barang_masuk.id_barang')
                // ->select('barangs.nama_barang', 'barang_masuk.*')
                ->where('tanggal', '>=' , $startDate)
                ->where('tanggal', '<=' , $endDate)
                ->groupBy('id_barang', 'tanggal')
                ->orderBy('tanggal', 'asc')
                ->get();

        dd($data);

        return view('barangKeluar.export', compact('data'));
    }
}
