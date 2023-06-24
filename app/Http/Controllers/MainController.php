<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MainController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['models'] = \App\Models\Main::latest()->paginate(50);
            return view('main_index', $data);
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
                flash('Data sudah disimpan')->success();
                return back();
            
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
                flash('Data sudah disimpan')->success();
                return back();
            
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
        return back();

    }
}
