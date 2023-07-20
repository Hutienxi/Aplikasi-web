@extends('layouts.template.master')
@section('content')
<div class="container-fluid mt-5">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">EDIT USER</div>

                    <div class="card-body">
                        <a href="{{ route('user') }}">
                            <button class="btn btn-danger float-end ">Kembali</button>
                        </a>
                        <br>
                        <form action="{{ route('user.update', ['id' => $user->id]) }}" method="POST">
                            @csrf

                            <div class="form-group mb-3">
                                <label for="">Nama</label><span class="text-danger">*</span>
                                <input type="text" name="name" class="form-control" value="{{ $user->name }}">
                                <span class="text-danger">{{ $errors->first('name') }}</span>
                            </div>

                            <div class="form-group mb-3">
                                <label for="">Role</label><span class="text-danger">*</span>
                                <select class="form-select" name="role">
                                    <option value="">--Pilih Role--</option>
                                    <option value="owner" {{ $user->role === 'owner' ? 'selected' : '' }}>Owner</option>
                                    <option value="admin" {{ $user->role === 'admin' ? 'selected' : '' }}>Admin</option>
                                </select>
                                <span class="text-danger">{{ $errors->first('role') }}</span>
                            </div>


                            <div class="form-group mb-3">
                                <label for="">Email</label><span class="text-danger">*</span>
                                <input type="email" name="email" class="form-control" value="{{ $user->email }}">
                                <span class="text-danger">{{ $errors->first('email') }}</span>
                            </div>

                            <div class="form-group mb-3">
                                <label for="">Password</label><span class="text-danger">*</span>
                                <input type="password" name="password" class="form-control">
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
