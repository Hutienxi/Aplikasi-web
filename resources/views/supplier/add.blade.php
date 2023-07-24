@extends('layouts.template.master')
@section('content')
<div class="container-fluid mt-5">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">TAMBAH DATA SUPPLIER</div>

                    <div class="card-body">
                        <a href="{{ route('supplier') }}">
                            <button class="btn btn-danger float-end ">Kembali</button>
                        </a>
                        <br>
                        <form action="{{ route('supplier.store') }}" method="POST">
                            @csrf

                            <div class="form-group mb-3">
                                <label for="">Nama</label><span class="text-danger">*</span>
                                <input type="text" name="nama" class="form-control" value="{{ old('nama') }}">
                                <span class="text-danger">{{ $errors->first('nama') }}</span>
                            </div>

                            <div class="form-group mb-3">
                                <label for="">Nomor Telpon</label><span class="text-danger">*</span>
                                <input type="text" name="no_telp" class="form-control" value="{{ old('no_telp') }}">
                                <span class="text-danger">{{ $errors->first('no_telp') }}</span>
                            </div>

                            <div class="form-group mb-3">
                                <label for="">Alamat</label><span class="text-danger">*</span>
                                <input type="text" name="alamat" class="form-control" value="{{ old('alamat') }}">
                                <span class="text-danger">{{ $errors->first('alamat') }}</span>
                            </div>

                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </form>

                    </div>
            </div>
        </div>
    </div>
</div>

@endsection
