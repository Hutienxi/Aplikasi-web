<?php

namespace App\Http\Controllers;

use App\Models\Stock;
use Auth;
use DB;
use Illuminate\Http\Request;
use Toastr;
use Yajra\DataTables\Facades\DataTables;

class StokController extends Controller
{
    public function index()
    {
        return view('stock.data');
    }

    public function ajax(Request $request)
    {

       $data = DataTables::eloquent(Stock::query())
        ->addColumn('no', function ($data) {
        // The 'DT_RowIndex' property provides an auto-incrementing index

            return '';
        })
        ->addColumn('action', function ($data) {
            $button = '';
            $urlEdit = route('stock.edit', ['id' => $data->id]);
            $urlHapus = route('stock.destroy', ['id' => $data->id]);


            $btnAction = '

            ';
            // $btnAction = '
            //     <div class="d-flex justify-content-center align-items-center">

            //         <a href="' . $urlEdit . '" >
            //             <button type="button" class="btn btn-warning mx-2 text-white" value="' . $data->id . '" >
            //             <i class="fas fa-edit"></i> Edit
            //             </button>
            //         </a>

            //         <a href="' . $urlHapus . '" >
            //             <button type="button" class="btn btn-danger text-white" value="' . $data->id . '"  onclick="return confirm(\'Are you sure you want to delete this record?\');">
            //             <i class="fas fa-delete"></i> Hapus
            //             </button>
            //         </a>

            //     </div>
            // ';



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

            $id_barang = '<div class="text-center">' . $merk . '</div>';

            return $id_barang;
        })

        ->addColumn('qty', function ($data) {
            $qty = '
                <div class="text-center"> ' . $data->qty . ' </div>
            ';
            return $qty;
        })

        ->addColumn('created_at', function ($data) {
            $created_at = '
                <div class="text-center"> ' . $data->created_at . ' </div>
            ';
            return $created_at;
        })
        ->addColumn('updated_at', function ($data) {
            $updated_at = '
                <div class="text-center"> ' . $data->updated_at. ' </div>
            ';
            return $updated_at;
        })
        ->rawColumns(['action','no', 'id_barang','merk', 'created_at', 'updated_at', 'qty'])
        ->toJson();

        return $data;

    }

    public function create()
    {
        $data = DB::table('barangs')
                // ->join('stocks', 'stocks.id_barang', '=', 'barangs.id')
                // ->select('barangs.*', 'stocks.*')
                ->get();
        // dd($data);

        return view('stock.add', compact('data'));
    }

    public function store(Request $request)
    {
        $request->validate(
            [
                'id_barang' => 'required',
                'qty' => 'required',
            ],
            [
                'id_barang.required' => 'nama barang tidak boleh kosong',
                'id_barang.unique' => 'nama barang sudah ada',
                'qty.required' => 'jumlah stock tidak boleh kosong',
            ]
        );

        $simpanData = new Stock();
        $simpanData->id_barang = $request->id_barang;
        $simpanData->qty = $request->qty;
        $simpanData->save();

        Toastr::success('Data berhasil di simpan ', 'Success');
        return redirect(route('stock.index'));

    }

    public function edit(Request $request, $id)
    {
        $data = Stock::join('barangs', 'stocks.id_barang', '=', 'barangs.id')
            ->select('stocks.*', 'barangs.nama_barang')
            ->where('stocks.id', $id)
            ->first();

        if (!$data) {
            return redirect()->route('stock.index')->withErrors('Data tidak ditemukan');
        }

        return view('stock.edit', compact('data'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'id_barang' => 'required',
            'qty' => 'required',
        ], [
            'id_barang.required' => 'Nama barang tidak boleh kosong',
            'id_barang.unique' => 'Nama barang sudah ada',
            'qty.required' => 'Jumlah stock tidak boleh kosong',
        ]);

        $simpanData = Stock::where('id', $id)->first();

        if ($simpanData->id == $id) {
            $simpanData->id_barang = $request->id_barang;
            $simpanData->qty = $request->qty;
            $simpanData->update();

            Toastr::success('Data berhasil diupdate', 'Success');
            return redirect(route('stock.index'));
        } else {
            Toastr::error('Nama barang tidak sesuai dengan yang sebelumnya!', 'Warning');
            return redirect(route('stock.edit', $id));
        }
    }

    public function destroy(Request $request, $id)
    {
        $data = Stock::where('id', $id)->delete();

        Toastr::warning('Data berhasil di hapus ', 'Info');
        return redirect(route('stock.index'));
    }

}
