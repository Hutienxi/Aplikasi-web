@extends('layouts.template.master')
@section('content')
<div class="container-fluid mt-5">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">EDIT STOCK BARANG</div>
                <div class="card-body">
                    <a href="{{ route('stock.index') }}">
                        <button class="btn btn-danger float-end">Kembali</button>
                    </a>
                    <br>
                    <form action="{{ route('stock.update', ['id' => $data->id]) }}" method="POST">
                        @csrf
                        <div class="form-group mb-3">
                            <label for="">Nama Barang</label><span class="text-danger">*</span>
                            <select class="form-select" name="id_barang">
                                <option selected>--Pilih Barang--</option>
                                <option value="{{ $data->id_barang }}" selected>
                                    {{ $data->nama_barang }}
                                </option>
                            </select>
                        </div>

                        <div class="form-group mb-3">
                            <label for="">Qty</label><span class="text-danger">*</span>
                            <input type="text" name="qty" class="form-control" value="{{ $data->qty }}">
                        </div>

                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection