<?php

namespace App\Http\Controllers;

use App\Exports\ExportBarangKeluar;
use App\Models\Barang;
use App\Models\BarangKeluar as ModelsBarangKeluar;
use App\Models\Stock;
use Carbon\Carbon;
use DB;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Toastr;
use Yajra\DataTables\Facades\DataTables;

class BarangKeluar extends Controller
{
    public function index()
    {
        return view('barangKeluar.data');
    }

    public function ajax(Request $request)
    {

       $data = DataTables::eloquent(ModelsBarangKeluar::query())
        ->addColumn('no', function ($data) {
        // The 'DT_RowIndex' property provides an auto-incrementing index

            return '';
        })
        ->addColumn('action', function ($data) {
            $button = '';
            $urlEdit = route('barangKeluar.edit', ['id' => $data->id]);
            $urlHapus = route('barangKeluar.destroy', ['id' => $data->id]);

            $btnAction = '
            <div class="d-flex justify-content-center align-items-center">

                <a href="' . $urlEdit . '" >
                    <button type="button" class="btn btn-warning mx-2 text-white" value="' . $data->id . '" >
                    <i class="fas fa-edit"></i> Edit
                    </button>
                </a>

                <a href="' . $urlHapus . '" >
                    <button type="button" class="btn btn-danger text-white" value="' . $data->id . '"  onclick="return confirm(\'Are you sure you want to delete this record?\');">
                    <i class="fas fa-delete"></i> Hapus
                    </button>
                </a>

            </div>
            ';


            $button .= $btnAction;
            // $button .= $edit;
            // $button .= $hapus;
            // $button .= $status;

            return $button;
        })
        ->addColumn('id_barang', function ($data) {
            $join = DB::table('barangs')
                ->leftJoin('stocks', 'stocks.id_barang', '=', 'barangs.id')
                ->select('barangs.nama_barang', 'stocks.*')
                ->where('barangs.id', $data->id_barang)
                ->first();

            $nama_barang = $join ? $join->nama_barang : 'Tidak ditemukan';

            $id_barang = '<div class="text-center">' . $nama_barang . '</div>';

            return $id_barang;
        })
        ->addColumn('merk', function ($data) {
            $join = DB::table('barangs')
                ->leftJoin('stocks', 'stocks.id_barang', '=', 'barangs.id')
                ->select('barangs.merk', 'stocks.*')
                ->where('barangs.id', $data->id_barang)
                ->first();

            $merk = $join ? $join->merk : 'Tidak ditemukan';

            $merk = '<div class="text-center">' . $merk . '</div>';

            return $merk;
        })

        ->addColumn('qty', function ($data) {
            $qty = '
                <div class="text-center"> ' . $data->qty . ' </div>
            ';
            return $qty;
        })
        ->addColumn('tanggal', function ($data) {
            $tanggal = '
                <div class="text-center"> ' . Carbon::parse($data->tanggal) . ' </div>
            ';
            return $tanggal;
        })
        ->addColumn('total', function ($data) {
            $join = DB::table('barangs')
            ->leftJoin('stocks', 'stocks.id_barang', '=', 'barangs.id')
            ->select('barangs.nama_barang', 'stocks.*')
            ->where('barangs.id', $data->id_barang)
            ->first();

            $nama_barang = $join ? $join->qty : 'Tidak ditemukan';

            $id_barang = '<div class="text-center">' . $nama_barang . '</div>';

        return $id_barang;
        })

        // ->addColumn('created_at', function ($data) {
        //     $created_at = '
        //         <div class="text-center"> ' . $data->created_at . ' </div>
        //     ';
        //     return $created_at;
        // })
        // ->addColumn('updated_at', function ($data) {
        //     $updated_at = '
        //         <div class="text-center"> ' . $data->updated_at. ' </div>
        //     ';
        //     return $updated_at;
        // })
        ->rawColumns(['action', 'no', 'id_barang','merk', 'qty', 'tanggal', 'total'])
        ->toJson();

        return $data;

    }

    public function create()
    {
        $data = DB::table('barangs')
                ->join('stocks', 'stocks.id_barang', '=', 'barangs.id')
                ->select('barangs.*', 'stocks.*')
                ->get();
        // dd($data);

        return view('barangKeluar.add', compact('data'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_barang' => 'required',
            'qty' => 'required',
            'tanggal' => 'required',
        ], [
            'id_barang.required' => 'nama barang tidak boleh kosong',
            'qty.required' => 'jumlah stock tidak boleh kosong',
            'tanggal.required' => 'tanggal tidak boleh kosong',
        ]);

        $idBarang = $request->id_barang;
        $qty = $request->qty;
        $tanggal = Carbon::now();


        $simpanData = new ModelsBarangKeluar();
        $simpanData->id_barang = $idBarang;
        $simpanData->qty = $qty;
        $simpanData->tanggal = $tanggal;


        $updateStok = Stock::where('id_barang', $simpanData->id_barang)->first();
        if ($updateStok->qty > $request->qty) {
            $updateStok->qty -= $qty;
            $updateStok->update();
            $simpanData->save();
        } else {
            Toastr::error('Stok tidak mencukupi! ', 'Failed');
            return redirect(route('barangKeluar.create'));
        }
        Toastr::success('Data berhasil di simpan ', 'Success');
        return redirect(route('barangKeluar'));
    }

    public function edit(Request $request, $id)
    {
        $data = Barang::join('barang_keluar', 'barangs.id', '=', 'barang_keluar.id_barang')
                ->select('barangs.*', 'barang_keluar.*')
                ->where('barang_keluar.id', $id)
                ->first();

        if (!$data) {
            return redirect()->route('barangKeluar')->withErrors('Data tidak ditemukan');
        }

        return view('barangKeluar.edit', compact('data'));
    }

    public function update(Request $request, $id)
    {
        $request->validate(
            [
                'id_barang' => 'required',
                'qty' => 'required',
                'tanggal' => 'required',
            ],
            [
                'id_barang.required' => 'nama barang tidak boleh kosong',
                'qty.required' => 'jumlah stock tidak boleh kosong',
                'tanggal.required' => 'tanggal tidak boleh kosong',
            ]
        );

        $edit =  ModelsBarangKeluar::where('id', $id)->first();
        $simpanData = ModelsBarangKeluar::where('id', $id)->first();

        // proses update stok pada model stok
        $stokLama = Stock::where('id_barang', $edit->id_barang)->first();
        $perhitunganAwal = $stokLama->qty += $edit->qty;

        // proses update data di model barang masuk
        $simpanData->id_barang = $request->id_barang;
        $simpanData->qty = $request->qty;
        $simpanData->tanggal = Carbon::now();

        // Proses final update stok
        $perhitunganAkhir = $stokLama->qty -= $request->qty;
        $stokLama->update();
        $simpanData->update();

        Toastr::success('Data berhasil di update ', 'Success');
        return redirect(route('barangKeluar'));

    }

    public function destroy(Request $request, $id)
    {
        $barangKeluar = ModelsBarangKeluar::where('id', $id)->first();
        $stokLama = Stock::where('id_barang', $barangKeluar->id_barang)->first();
        $perhitungan = $stokLama->qty += $barangKeluar->qty;
        // dd($perhitungan);

        // Update stok pada tabel 'stocks'
        Stock::where('id_barang', $barangKeluar->id_barang)
            ->update(['qty' => $perhitungan]);

        $barangKeluar->delete();

        Toastr::warning('Data berhasil di hapus ', 'Warning');
        return redirect(route('barangKeluar'));
    }

    public function export(Request $request)
    {


        $startDate = $request->startDate;
        $startDate = $startDate;

        $endDate = $request->endDate;
        $endDate = $endDate;


        $date = Carbon::now();

        $request->validate(
            [
                'startDate' => 'required',
                'endDate' => 'required',

            ],
            [
                'startDate.required' => 'Tanggal Awal tidak boleh kosong',
                'endDate.required' => 'Tanggal Akhir tidak boleh kosong',

            ]
        );

        if ($startDate > $endDate) {
            Toastr::error('Tanggal Awal tidak boleh lebih besar dari Tanggal Akhir');
            return back();
            // return back()->withErrors(['msg' => 'Tanggal Awal tidak boleh lebih besar dari Tanggal Akhir']);
        } else {

            return Excel::download(new ExportBarangKeluar, 'data-barang-keluar- ' . $startDate .  '-' . $endDate . '.xlsx');
        }
    }
}
