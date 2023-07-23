<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use Auth;
use Illuminate\Http\Request;
use Toastr;
use Yajra\DataTables\Facades\DataTables;

class MainController extends Controller
{

    public function index()
    {
        return view('main_index');
    }

    public function ajax(Request $request)
    {

       $data = DataTables::eloquent(Barang::query())
       ->addColumn('no', function ($data) {
            // The 'DT_RowIndex' property provides an auto-incrementing index

            return '';
        })
        ->addColumn('action', function ($data) {
            $button = '';
            $urlEdit = route('main.edit', ['id' => $data->id]);
            $urlHapus = route('main.destroy', ['id' => $data->id]);

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
                    <div class="d-flex justify-content-center align-items-center">

                        <a href="' . $urlHapus . '" >
                            <button type="button" class="btn btn-danger text-white" value="' . $data->id . '"  onclick="return confirm(\'Are you sure you want to delete this record?\');">
                            <i class="fas fa-delete"></i> Hapus
                            </button>
                        </a>

                    </div>
                ';
            }
            else {
                $btnAction = '
                    <div class="d-flex justify-content-center align-items-center">

                        <a href="' . $urlHapus . '" >
                            <button type="button" class="btn btn-danger text-white" value="' . $data->id . '"  onclick="return confirm(\'Are you sure you want to delete this record?\');">
                            <i class="fas fa-delete"></i> Hapus
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
        ->rawColumns(['action', 'no', 'nama_barang', 'merk', 'kategori', 'created_at', 'updated_at'])
        ->toJson();

        return $data;

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['model']  = new \App\Models\Barang();
        $data['method'] = 'POST';
        $data['route']  = 'main.store';
        $data['namaTombol'] = 'SIMPAN';
        return view('main_form', $data);

    }


    public function store(Request $request)
    {
            $requestData = $request->validate([
                    'nama_barang' => 'required',
                    // 'stock' => 'required|numeric',
                    'merk' => 'required',
                    'kategori' => 'required',
                ],
                [
                    'nama_barang.required' => 'nama barang tidak boleh kosong',
                    'merk.required' => 'merk tidak boleh kosong',
                    'kategori.required' => 'kategori tidak boleh kosong',
                ]);
                \App\Models\Barang::create($requestData);

                Toastr::success('Data berhasil di simpan ', 'Success');
                return redirect(route('main.index'));

    }


    public function show($id)
    {
        //
    }


    public function edit($id)
    {

        $data['model'] = \App\Models\Barang::findOrFail($id);
        $data['method'] = 'PUT';
        $data['route'] = ['main.update', $id];
        $data['namaTombol'] = 'UPDATE';
        return view('main_form', $data);
    }





    public function update(Request $request, $id)
    {
            $requestData = $request->validate([
                    // 'id_barang' => 'nullable' . $id,
                    'nama_barang' => 'required',
                    // 'stock' => 'required',
                    'merk' => 'required',
                    'kategori' => 'required',
            ]);
                //cari data yang akan diubah
                $model = \App\Models\Barang::findOrFail($id);
                //isi data model dengan data yang akan diupdate
                $model->fill($requestData);
                $pathFoto = null;
                if ($request->hasFile('foto')) {
            //hapus foto lama
                    \Storage::delete($model->foto);
                    $pathFoto = $request->file('foto')->store('public');
                    $model->foto = $pathFoto;
                    }
                $model->save();

                Toastr::success('Data berhasil di update ', 'Success');
                return redirect(route('main.index'));

    }


    public function destroy($id)
    {
        \App\Models\Barang::destroy($id);
        Toastr::success('Data berhasil di hapus ', 'Warning');
        return redirect(route('main.index'));

    }

}
