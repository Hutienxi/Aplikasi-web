<?php

namespace App\Exports;

use DB;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class ExportBarangMasuk implements FromView, ShouldAutoSize
{
   /**
     * @return \Illuminate\Support\Collection
     */
    public function view(): View
    {

        $startDate = request()->input('startDate');
        $startDate = date($startDate. ' 00:00:00');

        $endDate = request()->input('endDate');
        $endDate = date($endDate. ' 23:59:59');

        $data = DB::table('barang_masuk')
                ->select('id_barang', DB::raw('sum(qty) as totalBeli'), 'tanggal')
                // ->leftJoin('barangs', 'barangs.id', 'barang_masuk.id_barang')
                // ->select('barangs.nama_barang', 'barang_masuk.*')
                ->where('tanggal', '>=' , $startDate)
                ->where('tanggal', '<=' , $endDate)
                ->groupBy('id_barang', 'tanggal')
                ->orderBy('tanggal', 'asc')
                ->get();
        // dd($data);

        return view('barangMasuk.export', compact('data'));
    }
}
