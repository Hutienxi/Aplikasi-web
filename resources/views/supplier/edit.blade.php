@extends('layouts.template.master')
@section('content')
<div class="container-fluid mt-5">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">EDIT DATA SUPPLIER</div>
                <div class="card-body">
                    <a href="{{ route('stock.index') }}">
                        <button class="btn btn-danger float-end">Kembali</button>
                    </a>
                    <br>
                    <form action="{{ route('supplier.update', ['id' => $supplier->id]) }}" method="POST">
                        @csrf

                        <div class="form-group mb-3">
                            <label for="">Nama</label><span class="text-danger">*</span>
                            <input type="text" name="nama" class="form-control" value="{{ $supplier->nama }}">
                        </div>

                        <div class="form-group mb-3">
                            <label for="">Nomor Telepon</label><span class="text-danger">*</span>
                            <input type="text" name="no_telp" class="form-control" value="{{ $supplier->no_telp }}">
                        </div>

                        <div class="form-group mb-3">
                            <label for="">Alamat</label><span class="text-danger">*</span>
                            <input type="text" name="alamat" class="form-control" value="{{ $supplier->alamat }}">
                        </div>

                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
