<?php

namespace App\Http\Controllers;

use App\Models\Supplier as ModelsSupplier;
use Auth;
use Carbon\Carbon;
use DB;
use Illuminate\Http\Request;
use Toastr;
use Yajra\DataTables\Facades\DataTables;

class Supplier extends Controller
{
    public function index ()
    {
        return view('supplier.data');
    }

    public function ajax(Request $request)
    {

       $data = DataTables::eloquent(ModelsSupplier::query())
        ->addColumn('no', function ($data) {
        // The 'DT_RowIndex' property provides an auto-incrementing index

            return '';
        })
        ->addColumn('action', function ($data) {
            $button = '';
            $urlEdit = route('supplier.edit', ['id' => $data->id]);
            // $urlHapus = route('stock.destroy', ['id' => $data->id]);


            $btnAction = '

            ';
            if (Auth::user()-> role == 'owner') {
                $btnAction = '
                    <div class="d-flex justify-content-center align-items-center">

                        <a href="' . $urlEdit . '" >
                            <button type="button" class="btn btn-warning mx-2 text-white" value="' . $data->id . '" >
                            <i class="fas fa-edit"></i> Edit
                            </button>
                        </a>

                    </div>
                ';
            }


            $button .= $btnAction;
            // $button .= $edit;
            // $button .= $hapus;
            // $button .= $status;

            return $button;
        })
        ->addColumn('nama', function ($data) {
            $nama = '
                <div class="text-center"> ' . $data->nama . ' </div>
            ';
            return $nama;
        })

        ->addColumn('no_telp', function ($data) {
            $no_telp = '
                <div class="text-center"> ' . $data->no_telp . ' </div>
            ';
            return $no_telp;
        })
        ->addColumn('alamat', function ($data) {
            $alamat = '
                <div class="text-center"> ' . $data->alamat. ' </div>
            ';
            return $alamat;
        })
        ->rawColumns(['action','no', 'nama','no_telp', 'alamat', 'action'])
        ->toJson();

        return $data;

    }

    public function create()
    {
        return view('supplier.add');
    }

    public function store(Request $request)
    {
        $request->validate(
            [
                'nama' => 'required',
                'no_telp' => 'required',
                'alamat' => 'required',
            ],
            [
                'nama.required' => 'nama tidak boleh kosong',
                'no_telp' => 'nomor telpon tidak boleh kosong',
                'alamat' => 'alamat tidak boleh kosong'
            ]
        );

        $simpanData = new ModelsSupplier();
        $simpanData->nama = $request->nama;
        $simpanData->no_telp = $request->no_telp;
        $simpanData->alamat = $request->alamat;

        $simpanData->save();
        Toastr::success('Data Berhasil di simpan', 'Success');
        return redirect(route('supplier'));
    }

    public function edit(Request $request, $id)
    {
        $supplier = ModelsSupplier::find($id);

        return view('supplier.edit', compact('supplier'));
    }

    Public function update(Request $request, $id)
    {
        $validatedData = $request->validate(
            [
                'nama' => 'required',
                'no_telp' => 'required',
                'alamat' => 'required',
                // 'password' => 'required',

            ],
            [
                'nama.required' => 'nama tidak boleh kosong',
                'no_telp' => 'nomor telpon tidak boleh kosong',
                'alamat' => 'alamat tidak boleh kosong'
            ]
        );;

        $simpanData = ModelsSupplier::where('id', $id)->first();
        $simpanData->nama = $request->nama;
        $simpanData->no_telp = $request->no_telp;
        $simpanData->alamat = $request->alamat;

        $simpanData->updated_at = Carbon::now();
        $simpanData->update();

        Toastr::success('Data berhasil di update');
        return redirect(route('supplier'));
    }
}
