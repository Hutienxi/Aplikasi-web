<?php

namespace App\Http\Controllers;

use App\Models\Main;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class MainController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index()
    {
        return view('main_index');
    }

    public function ajax(Request $request)
    {
        return DataTables::eloquent(Main::query())
        ->addColumn('action', function ($data) {
            $button = '';
            $urlEdit = route('main.edit', ['id' => $data->id]);
            $urlHapus = route('main.destroy', ['id' => $data->id]);

            $btnAction = '
            <div class="d-flex justify-content-center align-items-center">

                <a href="' . $urlEdit . '" >
                    <button type="button" class="btn btn-warning btn-sm ml-2" value="' . $data->id . '" >
                    </button>
                </a>

                <a href="' . $urlHapus . '" >
                    <button type="button" class="btn btn-danger btn-sm ml-2" value="' . $data->id . '"  onclick="return confirm(\'Are you sure you want to delete this record?\');">
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
        ->addColumn('nama_barang', function ($data) {
            $nama_barang = '
                <div style="width: 100%; text-align:center;"> ' . $data->nama_barang . ' </div>
            ';
            return $nama_barang;
        })
        ->addColumn('stock', function ($data) {
            $stock = '
                <div style="width: 100%; text-align:center;"> ' . $data->stock . ' </div>
            ';
            return $stock;
        })
        ->addColumn('merk', function ($data) {
            $merk = '
                <div style="width: 100%; text-align:center;"> ' . $data->merk . ' </div>
            ';
            return $merk;
        })
        ->addColumn('kategori', function ($data) {
            $kategori = '
                <div style="width: 100%; text-align:center;"> ' . $data->kategori . ' </div>
            ';
            return $kategori;
        })
        ->addColumn('created_at', function ($data) {
            $created_at = '
                <div style="width: 100%; text-align:center;"> ' . $data->created_at . ' </div>
            ';
            return $created_at;
        })
        ->addColumn('updated_at', function ($data) {
            $updated_at = '
                <div style="width: 100%; text-align:center;"> ' . $data->updated_at. ' </div>
            ';
            return $updated_at;
        })
        ->rawColumns(['action', 'nama_barang', 'stock', 'merk', 'kategori', 'created_at', 'updated_at'])
        ->toJson();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['model']  = new \App\Models\Main();
        $data['method'] = 'POST';
        $data['route']  = 'main.store';
        $data['namaTombol'] = 'SIMPAN';
        return view('main_form', $data);

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
            $requestData = $request->validate([
                    'nama_barang' => 'required',
                    'stock' => 'required|numeric',
                    'merk' => 'required',
                    'kategori' => 'required',
                ]);
                \App\Models\Main::create($requestData);
                flash('Data berhasil disimpan')->success();
                return redirect(route('main.index'));

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

        $data['model'] = \App\Models\Main::findOrFail($id);
        $data['method'] = 'PUT';
        $data['route'] = ['main.update', $id];
        $data['namaTombol'] = 'UPDATE';
        return view('main_form', $data);
    }




    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
            $requestData = $request->validate([
                    'id_barang' => 'nullable' . $id,
                    'nama_barang' => 'required',
                    'stock' => 'required|numeric',
                    'merk' => 'required',
                    'kategori' => 'required',
            ]);
                //cari data yang akan diubah
                $model = \App\Models\Main::findOrFail($id);
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
                flash('Data berhasil diupdate')->success();
                return redirect(route('main.index'));

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        \App\Models\Main::destroy($id);
        flash('Data sudah dihapus')->success();
        return redirect(route('main.index'));

    }
}
