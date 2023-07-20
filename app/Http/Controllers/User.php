<?php

namespace App\Http\Controllers;

use App\Models\User as ModelsUser;
use Carbon\Carbon;
use DB;
use Illuminate\Http\Request;
use Toastr;
use Yajra\DataTables\Facades\DataTables;

class User extends Controller
{
    public function index()
    {
        return view('user.data');
    }

    public function ajax(Request $request)
    {

       $data = DataTables::eloquent(ModelsUser::query())
        ->addColumn('no', function ($data) {
            // The 'DT_RowIndex' property provides an auto-incrementing index

            return '';
        })
        ->addColumn('action', function ($data) {
            $button = '';
            $urlEdit = route('user.edit', ['id' => $data->id]);
            $urlHapus = route('user.destroy', ['id' => $data->id]);

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
        ->addColumn('name', function ($data) {
            $name = '
                <div class="text-center"> ' . $data->name . ' </div>
            ';
            return $name;
        })
        ->addColumn('email', function ($data) {
            $email = '
                <div class="text-center"> ' . $data->email . ' </div>
            ';
            return $email;
        })
        ->addColumn('role', function ($data) {
            $role = '
                <div class="text-center"> ' . $data->role . ' </div>
            ';
            return $role;
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
        ->rawColumns(['action', 'name', 'role', 'email', 'created_at', 'updated_at'])
        ->toJson();

        return $data;

    }

    public function create()
    {
        return view('user.add');
    }

    public function store(Request $request)
    {
        $request->validate(
            [
                'name' => 'required',
                'role' => 'required',
                'email' => 'required|unique:users',
                'password' => 'required'
            ],
            [
                'name.required' => 'nama tidak boleh kosong',
                'role.required' => 'role tidak boleh kosong',
                'email.required' => 'email tidak boleh kosong',
                'email.unique' => 'email sudah terdaftar',
                'password.required' => 'password tidak boleh kosong'
            ]);

            $user = new ModelsUser();
            $user->name = $request->name;
            $user->role = $request->role;
            $user->email = $request->email;
            $user->password = bcrypt($request->password);
            $user->save();

            Toastr::success('User dengan nama ' . $user->name . ' berhasil di buat');
            return redirect(route('user'));
    }

    public function edit($id)
    {
        $user = ModelsUser::find($id);

        return view('user.edit', compact('user'));
        // dd($user);
    }

    Public function update(Request $request, $id)
    {
        $validatedData = $request->validate(
            [
                'name' => 'required',
                'role' => 'required',
                'email' => 'required',
                // 'password' => 'required',

            ],
            [

                'nama.required' => 'kolom nama tidak boleh kosong',
                'role.required' => 'kolom role tidak boleh kosong',
                'email.required' => 'kolom email tidak boleh kosong',
                'password.required' => 'kolom password tidak boleh kosong',


            ]
        );;

        $simpanData = ModelsUser::where('id', $id)->first();
        $simpanData->name = $request->name;
        $simpanData->role = $request->role;
        // $simpanData->email = $request->email;

        $data = $request->except(['action', '_token']);
        if ($request->email != '') {
            $request->merge(['email' => $request->get('email')]);
            $data = $request->except(['action', '_token']);
        } else {
            $data = $request->except(['action', '_token', 'email']);
        }

        if ($request->password != '') {
            $request->merge(['password' => bcrypt($request->get('password'))]);
            $data = $request->except(['action', '_token']);
        } else {
            $data = $request->except(['action', '_token', 'password']);
        }

        $simpanData->updated_at = Carbon::now();
        $simpanData->where(['id' => $id])->update($data);

        Toastr::success('User dengan nama ' . $simpanData->name . ' berhasil di update');
        return redirect(route('user'));
    }

    public function destroy(Request $request, $id)
    {
        $data = ModelsUser::where('id', $id)->delete();

        Toastr::warning('Data berhasil di hapus ', 'Info');
        return redirect(route('user'));
    }
}
