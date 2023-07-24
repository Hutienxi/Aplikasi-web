@extends('layouts.template.master')
@section('content')
<div class="container-fluid mt-5">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">TAMBAH DATA PENGGUNA</div>

                    <div class="card-body">
                        <a href="{{ route('user') }}">
                            <button class="btn btn-danger float-end ">Kembali</button>
                        </a>
                        <br>
                        <form action="{{ route('user.store') }}" method="POST">
                            @csrf

                            <div class="form-group mb-3">
                                <label for="">Nama</label><span class="text-danger">*</span>
                                <input type="text" name="name" class="form-control" value="{{ old('name') }}">
                                <span class="text-danger">{{ $errors->first('name') }}</span>
                            </div>

                            <div class="form-group mb-3">
                                <label for="">Role</label><span class="text-danger">*</span>
                                <select class="form-select" name="role">
                                    <option>--Pilih Role--</option>
                                    <option value="owner">Owner</option>
                                    <option value="admin">Admin</option>

                                </select>
                                <span class="text-danger">{{ $errors->first('role') }}</span>
                            </div>

                            <div class="form-group mb-3">
                                <label for="">Email</label><span class="text-danger">*</span>
                                <input type="email" name="email" class="form-control" value="{{ old('email') }}">
                                <span class="text-danger">{{ $errors->first('email') }}</span>
                            </div>

                            <div class="form-group mb-3">
                                <label for="">Password</label><span class="text-danger">*</span>
                                <input type="password" name="password" class="form-control" value="{{ old('password') }}">
                                <span class="text-danger">{{ $errors->first('password') }}</span>
                            </div>

                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </form>

                    </div>
            </div>
        </div>
    </div>
</div>

@endsection
