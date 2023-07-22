<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use DB;
use Toastr;
use Yajra\DataTables\Facades\DataTables;
use App\Models\BarangMasuk as ModelsBarangMasuk;
use App\Models\LaporanBarangMasuk;

class LaporanBarang extends Controller
{
    public function barangMasuk()
    {
        return view('laporan.barangMasuk');
    }

    public function barangMasukAjax()
    {
            $query = DB::table('laporan_barang_masuk')
                ->select('laporan_barang_masuk.id_barang', 'laporan_barang_masuk.tanggal', DB::raw('SUM(laporan_barang_masuk.qty) as totalBeli'), 'laporan_barang_masuk.stok_awal')
                // ->leftJoin('barangs', 'barangs.id', '=', 'barang_masuk.id_barang')
                ->groupBy('laporan_barang_masuk.id_barang', 'laporan_barang_masuk.tanggal', 'laporan_barang_masuk.stok_awal')
                ->orderBy('laporan_barang_masuk.tanggal', 'asc') // Urutkan data berdasarkan tanggal secara ascending
                ->get();

            dd($query);

            $formattedData = [];
            $stokAwal = 0; // Inisialisasi stok awal dengan 0

            foreach ($query as $row) {
                $join = DB::table('barangs')
                    ->leftJoin('stocks', 'stocks.id_barang', '=', 'barangs.id')
                    ->select('barangs.*', 'stocks.*')
                    ->where('barangs.id', $row->id_barang)
                    ->first();

                $nama_barang = $join ? $join->nama_barang : 'Tidak ditemukan';


                $formattedData[] = [
                    'id_barang' => $row->id_barang,
                    'totalBeli' => $row->totalBeli,
                    'tanggal' => Carbon::parse($row->tanggal)->format('Y-m-d'),
                    'nama_barang' => $nama_barang,
                    'merk' => $join->merk,
                    'stokAwal' => $row->stok_awal,
                    'stokAkhir' => $row->stok_awal + $row->totalBeli
                ];
                // dd($row->stok_awal);
            }

            $data = DataTables::collection($formattedData)
            ->addColumn('no', function ($data) {
                // The 'DT_RowIndex' property provides an auto-incrementing index
                return '';
            })
            ->addColumn('id_barang', function ($data) {
                $id_barang = '<div class="text-center">' . $data['nama_barang'] . '</div>';
                return $id_barang;
            })
            ->addColumn('merk', function ($data) {
                $merk = '<div class="text-center">' . $data['merk'] . '</div>';
                return $merk;
            })
            ->addColumn('stokAwal', function ($data) {
                $stokAwal = '<div class="text-center">' . $data['stokAwal'] . '</div>';
                return $stokAwal;
            })
            ->addColumn('qty', function ($data) {
                $qty = '<div class="text-center">' . $data['totalBeli'] . '</div>';
                return $qty;
            })
            ->addColumn('stokAkhir', function ($data) {
                $qty = '<div class="text-center">' . $data['stokAkhir'] . '</div>';
                return $qty;
            })
            ->addColumn('tanggal', function ($data) {
                $tanggal = '<div class="text-center">' . $data['tanggal'] . '</div>';
                return $tanggal;
            })
            ->rawColumns(['no', 'id_barang','merk', 'qty', 'stokAwal', 'stokAkhir', 'tanggal'])
            ->toJson();

        return $data;
    }


    // public function barangMasukAjax()
    // {
    //     $query = DB::table('barang_masuk')
    //         ->select('barang_masuk.id_barang', 'barang_masuk.tanggal', DB::raw('SUM(barang_masuk.qty) as totalBeli'))
    //         ->leftJoin('barangs', 'barangs.id', '=', 'barang_masuk.id_barang')
    //         ->groupBy('barang_masuk.id_barang', 'barang_masuk.tanggal')
    //         ->orderBy('barang_masuk.tanggal', 'asc') // Urutkan data berdasarkan tanggal secara ascending
    //         ->get();


    //     $formattedData = [];
    //     $stokAwal = 0; // Inisialisasi stok awal dengan 0

    //     foreach ($query as $row) {
    //         $join = DB::table('barangs')
    //             ->leftJoin('stocks', 'stocks.id_barang', '=', 'barangs.id')
    //             ->select('barangs.*', 'stocks.*')
    //             ->where('barangs.id', $row->id_barang)
    //             ->first();

    //         $nama_barang = $join ? $join->nama_barang : 'Tidak ditemukan';


    //         // Ambil stok awal hanya pada iterasi pertama
    //         if (empty($formattedData)) {
    //             $stokAwalQuery = DB::table('stocks')
    //                             ->select('stocks.id', 'stocks.qty')
    //                             ->leftJoin('barang_masuk', 'barang_masuk.id_barang', '=', 'stocks.id')
    //                             ->where('barang_masuk.id_barang', $row->id_barang)
    //                             ->where('barang_masuk.tanggal', '<', $row->tanggal)
    //                             ->orderBy('barang_masuk.tanggal', 'desc')
    //                             ->first();

    //             $stokAwal = $stokAwalQuery ? $stokAwalQuery->qty : 0; // Jika ada stok awal sebelumnya, gunakan nilai tersebut, jika tidak, gunakan 0
    //             // $stokAwalAkhir = $stokAwal + intval($row->totalBeli); // Hitung stok akhir berdasarkan stok awal dan totalBeli
    //         }

    //         // $stokAwal = $stokAwalQuery ? $stokAwalQuery->qty : 0; // Jika ada stok awal sebelumnya, gunakan nilai tersebut, jika tidak, gunakan 0

    //         $stokAkhir = $stokAwal + intval($row->totalBeli); // Hitung stok akhir berdasarkan stok awal dan totalBeli

    //         $formattedData[] = [
    //             'id_barang' => $row->id_barang,
    //             'totalBeli' => $row->totalBeli,
    //             'tanggal' => Carbon::parse($row->tanggal)->format('d-m-Y'),
    //             'nama_barang' => $nama_barang,
    //             'merk' => $join->merk,
    //             'stokAwal' => $stokAwal,
    //             'stokAkhir' => $stokAkhir,
    //         ];

    //         $stokAwal = $stokAkhir; // Atur stok akhir sebagai stok awal untuk iterasi selanjutnya
    //     }

    //     $data = DataTables::collection($formattedData)
    //         ->addColumn('no', function ($data) {
    //             // The 'DT_RowIndex' property provides an auto-incrementing index
    //             return '';
    //         })
    //         ->addColumn('id_barang', function ($data) {
    //             $id_barang = '<div class="text-center">' . $data['nama_barang'] . '</div>';
    //             return $id_barang;
    //         })
    //         ->addColumn('merk', function ($data) {
    //             $merk = '<div class="text-center">' . $data['merk'] . '</div>';
    //             return $merk;
    //         })
    //         ->addColumn('stokAwal', function ($data) {
    //             $stokAwal = '<div class="text-center">' . $data['stokAwal'] . '</div>';
    //             return $stokAwal;
    //         })
    //         ->addColumn('qty', function ($data) {
    //             $qty = '<div class="text-center">' . $data['totalBeli'] . '</div>';
    //             return $qty;
    //         })
    //         ->addColumn('stokAkhir', function ($data) {
    //             $stokAkhir = '<div class="text-center">' . $data['stokAkhir'] . '</div>';
    //             return $stokAkhir;
    //         })
    //         ->addColumn('tanggal', function ($data) {
    //             $tanggal = '<div class="text-center">' . $data['tanggal'] . '</div>';
    //             return $tanggal;
    //         })
    //         ->rawColumns(['no', 'id_barang', 'merk', 'stokAwal', 'qty', 'stokAkhir', 'tanggal'])
    //         ->toJson();

    //     return $data;
    // }


    // public function export()
    // {
    //         $subQuery1 = DB::table('barang_masuk')
    //         ->select('id_barang', DB::raw('SUM(qty) as total_beli'), DB::raw('0 as total_jual'), 'tanggal')
    //         ->groupBy('id_barang', 'tanggal');

    //         $subQuery2 = DB::table('barang_keluar')
    //             ->select('id_barang', DB::raw('0 as total_beli'), DB::raw('SUM(qty) as total_jual'), 'tanggal')
    //             ->groupBy('id_barang', 'tanggal');

    //         $unionQuery = DB::table(DB::raw("({$subQuery1->toSql()} UNION ALL {$subQuery2->toSql()}) as combined_table"))
    //             ->mergeBindings($subQuery1)
    //             ->mergeBindings($subQuery2)
    //             ->select('id_barang', DB::raw('SUM(total_beli) as total_beli'), DB::raw('SUM(total_jual) as total_jual'), 'tanggal')
    //             ->groupBy('id_barang', 'tanggal')
    //             ->orderBy('tanggal', 'asc')
    //             ->get();

    //         $combinedData = collect($unionQuery)->groupBy('id_barang', 'tanggal')->map(function ($item) {
    //             return [
    //                 'id_barang' => $item->first()->id_barang,
    //                 'total_beli' => $item->sum('total_beli'),
    //                 'total_jual' => $item->sum('total_jual'),
    //                 'tanggal' => $item->first()->tanggal,
    //             ];
    //         })->values();

    //         // Calculate stok_awal and add it to the $combinedData array
    //         $stokAwal = 0;

    //         $modifiedCombinedData = $combinedData->map(function ($data) {
    //             $stokAwalQuery = DB::table('stocks')
    //                 ->select(DB::raw('SUM(qty) as stok_awal'))
    //                 ->where('id_barang', $data['id_barang'])
    //                 ->first();

    //             $stokAkhirQuery = DB::table('barang_keluar')
    //                 ->select(DB::raw('SUM(qty) as total_jual'))
    //                 ->where('id_barang', $data['id_barang'])
    //                 ->first();

    //             $getStok = DB::table('stocks')
    //                 ->select('qty')
    //                 ->where('id_barang', $data['id_barang'])
    //                 ->first();

    //             $stokAwal = $stokAwalQuery ? $stokAwalQuery->stok_awal : 0;
    //             $stokAkhir = $getStok;

    //             $hitungStokAwal = $stokAwal - $data['total_beli'] + $data['total_jual'];
    //             // dd($getStok);

    //             if($stokAkhir == null){
    //                 $hitungStokAkhir = $hitungStokAwal + $data['total_beli'] - 0;
    //             }else{
    //                 $hitungStokAkhir = $hitungStokAwal + $data['total_beli'];
    //             }
    //             // $stokAkhir = $stokAwal + $data['total_beli'] - $data['total_jual'];

    //             $data['stok_awal'] = $hitungStokAwal;
    //             $data['stok_akhir'] = $stokAkhir;

    //             $stokAwal = $hitungStokAkhir;

    //             return $data;
    //         });

    //         dd($modifiedCombinedData);


    // }

    // public function barangMasukAjax()
    // {
    //     $query = DB::table('barang_masuk')
    //             ->select('barang_masuk.id_barang', 'barang_masuk.tanggal', DB::raw('SUM(barang_masuk.qty) as totalBeli'))
    //             ->leftJoin('barangs', 'barangs.id', '=', 'barang_masuk.id_barang')
    //             ->groupBy('barang_masuk.id_barang', 'barang_masuk.tanggal')
    //             ->orderBy('barang_masuk.tanggal', 'asc') // Urutkan data berdasarkan tanggal secara ascending
    //             ->get();


    //         $formattedData = [];
    //         $stokAwal = 0; // Inisialisasi stok awal dengan 0

    //         foreach ($query as $row) {
    //             $join = DB::table('barangs')
    //                 ->leftJoin('stocks', 'stocks.id_barang', '=', 'barangs.id')
    //                 ->select('barangs.*', 'stocks.*')
    //                 ->where('barangs.id', $row->id_barang)
    //                 ->first();

    //             $nama_barang = $join ? $join->nama_barang : 'Tidak ditemukan';


    //             // Ambil stok awal hanya pada iterasi pertama
    //             if (empty($formattedData)) {
    //                 $stokAwalQuery = DB::table('stocks')
    //                                 ->select(DB::raw('SUM(qty) as stok_awal'))
    //                                 ->where('id_barang', $row->id_barang)
    //                                 ->first();
    //                 // dd($stokAwalQuery);
    //                 $stokAwal = $stokAwalQuery ? $stokAwalQuery->stok_awal : 0; // Jika ada stok awal sebelumnya, gunakan nilai tersebut, jika tidak, gunakan 0
    //                 $perhitunganStokAwal = $stokAwal - intval($row->totalBeli); // Hitung stok akhir berdasarkan stok awal dan totalBeli
    //             }

    //             // $stokAwal = $stokAwalQuery ? $stokAwalQuery->qty : 0; // Jika ada stok awal sebelumnya, gunakan nilai tersebut, jika tidak, gunakan 0

    //             $stokAkhir = $perhitunganStokAwal + intval($row->totalBeli); // Hitung stok akhir berdasarkan stok awal dan totalBeli

    //             $formattedData[] = [
    //                 'id_barang' => $row->id_barang,
    //                 'totalBeli' => $row->totalBeli,
    //                 'tanggal' => Carbon::parse($row->tanggal)->format('Y-m-d'),
    //                 'nama_barang' => $nama_barang,
    //                 'merk' => $join->merk,
    //                 'stokAwal' => $perhitunganStokAwal,
    //                 'stokAkhir' => $stokAkhir,
    //             ];

    //             $stokAwal = $stokAkhir; // Atur stok akhir sebagai stok awal untuk iterasi selanjutnya
    //         }

    //         $data = DataTables::collection($formattedData)
    //             ->addColumn('no', function ($data) {
    //                 // The 'DT_RowIndex' property provides an auto-incrementing index
    //                 return '';
    //             })
    //             ->addColumn('id_barang', function ($data) {
    //                 $id_barang = '<div class="text-center">' . $data['nama_barang'] . '</div>';
    //                 return $id_barang;
    //             })
    //             ->addColumn('merk', function ($data) {
    //                 $merk = '<div class="text-center">' . $data['merk'] . '</div>';
    //                 return $merk;
    //             })
    //             ->addColumn('stokAwal', function ($data) {
    //                 $stokAwal = '<div class="text-center">' . $data['stokAwal'] . '</div>';
    //                 return $stokAwal;
    //             })
    //             ->addColumn('qty', function ($data) {
    //                 $qty = '<div class="text-center">' . $data['totalBeli'] . '</div>';
    //                 return $qty;
    //             })
    //             ->addColumn('stokAkhir', function ($data) {
    //                 $stokAkhir = '<div class="text-center">' . $data['stokAkhir'] . '</div>';
    //                 return $stokAkhir;
    //             })
    //             ->addColumn('tanggal', function ($data) {
    //                 $tanggal = '<div class="text-center">' . $data['tanggal'] . '</div>';
    //                 return $tanggal;
    //             })
    //             ->rawColumns(['no', 'id_barang', 'merk', 'stokAwal', 'qty', 'stokAkhir', 'tanggal'])
    //             ->toJson();

    //     return $data;
    // }


}
