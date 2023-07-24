<?php

namespace App\Http\Controllers;

use App\Models\Barang as ModelsBarang;
use App\Models\Supplier;
use Auth;
use Carbon\Carbon;
use DB;
use Illuminate\Http\Request;
use Toastr;
use Yajra\DataTables\Facades\DataTables;

class Barang extends Controller
{
    public function index ()
    {
        return view('barang.data');
    }

    public function ajax(Request $request)
    {

       $data = DataTables::eloquent(ModelsBarang::query())
       ->addColumn('no', function ($data) {
            // The 'DT_RowIndex' property provides an auto-incrementing index

            return '';
        })
        ->addColumn('action', function ($data) {
            $button = '';
            $urlEdit = route('barang.edit', ['id' => $data->id]);
            // $urlHapus = route('main.destroy', ['id' => $data->id]);

            // $btnAction = '
            //         <div class="d-flex justify-content-center align-items-center">

            //             <a href="' . $urlEdit . '" >
            //                 <button type="button" class="btn btn-warning mx-2 text-white" value="' . $data->id . '" >
            //                 <i class="fas fa-edit"></i> Edit
            //                 </button>
            //             </a>

            //             <a href="' . $urlHapus . '" >
            //                 <button type="button" class="btn btn-danger text-white" value="' . $data->id . '"  onclick="return confirm(\'Are you sure you want to delete this record?\');">
            //                 <i class="fas fa-delete"></i> Hapus
            //                 </button>
            //             </a>

            //         </div>
            //     ';
            if(Auth::user()->role == 'owner'){
                $btnAction = '
                <a href="' . $urlEdit . '" >
                    <button type="button" class="btn btn-warning mx-2 text-white" value="' . $data->id . '" >
                    <i class="fas fa-edit"></i> Edit
                    </button>
                </a>
                ';
            }
            else {
                $btnAction = '

                ';
            }




            $button .= $btnAction;
            // $button .= $edit;
            // $button .= $hapus;
            // $button .= $status;

            return $button;
        })
        ->addColumn('nama_barang', function ($data) {
            $nama = '
                <div class="text-center"> ' . $data->nama_barang . ' </div>
            ';
            return $nama;
        })
        ->addColumn('merk', function ($data) {
            $merk = '
                <div class="text-center"> ' . $data->merk . ' </div>
            ';
            return $merk;
        })
        ->addColumn('supplier', function ($data) {
            $join = DB::table('suppliers')
            ->leftJoin('barangs', 'barangs.id_supplier', '=', 'suppliers.id')
            ->select('suppliers.nama', 'barangs.*')
            ->where('suppliers.id', $data->id_supplier)
            ->first();

        $nama_barang = $join ? $join->nama : 'Tidak ditemukan';

        $id_barang = '<div class="text-center">' . $nama_barang . '</div>';

        return $id_barang;
        })
        ->addColumn('kategori', function ($data) {
            $kategori = '
                <div class="text-center"> ' . $data->kategori . ' </div>
            ';
            return $kategori;
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
        ->rawColumns(['action', 'no', 'nama_barang', 'merk', 'supplier', 'kategori', 'created_at', 'updated_at'])
        ->toJson();

        return $data;

    }

    public function create()
    {
        $supplier = Supplier::get();
        return view('barang.add', compact('supplier'));
    }

    public function store(Request $request)
    {
        $request->validate(
            [
                'nama_barang' => 'required',
                'merk' => 'required',
                'id_supplier' => 'required',
                'kategori' => 'required'
            ],
            [
                'nama_barang.required' => 'nama barang tidak boleh kosong',
                'merk' => 'merk tidak boleh kosong',
                'id_supplier' => 'supplier tidak boleh kosong',
                'kategori' => 'kategori tidak boleh kosong'
            ]
        );

        $simpanData = new ModelsBarang();
        $simpanData->nama_barang = $request->nama_barang;
        $simpanData->merk = $request->merk;
        $simpanData->id_supplier = $request->id_supplier;
        $simpanData->kategori = $request->kategori;

        $simpanData->save();
        Toastr::success('Data berhasil di simpan', 'Success');
        return redirect(route('barang'));
    }

    public function edit(Request $request, $id)
    {
        $find = ModelsBarang::find($id);
        $supplier = Supplier::get();

        // if (!$find) {
        //     return redirect()->route('barang')->withErrors('Data tidak ditemukan');
        // }

        // $idSupplier = $find->id_supplier;

        // $join = DB::table('suppliers')
        // ->leftJoin('barangs', 'barangs.id_supplier', '=', 'suppliers.id')
        // ->select('suppliers.nama', 'barangs.*')
        // ->where('suppliers.id', $idSupplier)
        // ->first();



        // $data = ModelsBarang::join('suppliers', 'barangs.id_supplier', '=', 'suppliers.id')
        //     ->select('barangs.id_supplier', 'suppliers.nama')
        //     ->where('suppliers.id', $idSupplier)
        //     ->first();

        //     dd($data);

        return view('barang.edit', compact('find', 'supplier'));
    }

    Public function update(Request $request, $id)
    {
        $request->validate(
            [
                'nama_barang' => 'required',
                'merk' => 'required',
                'id_supplier' => 'required',
                'kategori' => 'required'
            ],
            [
                'nama_barang.required' => 'nama barang tidak boleh kosong',
                'merk' => 'merk tidak boleh kosong',
                'id_supplier' => 'supplier tidak boleh kosong',
                'kategori' => 'kategori tidak boleh kosong'
            ]
        );

        $simpanData = ModelsBarang::where('id', $id)->first();
        $simpanData->nama_barang = $request->nama_barang;
        $simpanData->merk = $request->merk;
        $simpanData->id_supplier = $request->id_supplier;
        $simpanData->kategori = $request->kategori;


        $simpanData->updated_at = Carbon::now();
        $simpanData->update();

        Toastr::success('Data berhasil di update');
        return redirect(route('barang'));
    }

}
