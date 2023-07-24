@extends('layouts.template.master')
@section('content')
<div class="container-fluid mt-5">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">Edit DATA BARANG</div>

                    <div class="card-body">
                        <a href="{{ route('barang') }}">
                            <button class="btn btn-danger float-end ">Kembali</button>
                        </a>
                        <br>
                        <form action="{{ route('barang.update', ['id' => $find->id]) }}" method="POST">
                            @csrf

                            <div class="form-group mb-3">
                                <label for="">Nama Barang</label><span class="text-danger">*</span>
                                <input type="text" name="nama_barang" class="form-control" value="{{ $find->nama_barang }}">
                                <span class="text-danger">{{ $errors->first('nama_barang') }}</span>
                            </div>

                            <div class="form-group mb-3">
                                <label for="">Merk</label><span class="text-danger">*</span>
                                <input type="text" name="merk" class="form-control" value="{{ $find->merk }}">
                                <span class="text-danger">{{ $errors->first('merk') }}</span>
                            </div>

                            <div class="form-group mb-3">
                                <label for="">Supplier</label><span class="text-danger">*</span>
                                <select class="form-select" name="id_supplier">
                                    <option selected>--Pilih Supplier--</option>

                                    @foreach ($supplier as $val)
                                        <option value="{{ $val->id }}" @if($val->id === $find->id_supplier) selected @endif>
                                            {{ $val->nama }}
                                        </option>
                                    @endforeach

                                </select>
                                <span class="text-danger">{{ $errors->first('id_supplier') }}</span>
                            </div>


                            <div class="form-group mb-3">
                                <label for="">Kategori</label><span class="text-danger">*</span>
                                <input type="text" name="kategori" class="form-control" value="{{ $find->kategori }}">
                                <span class="text-danger">{{ $errors->first('kategori') }}</span>
                            </div>

                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </form>

                    </div>
            </div>
        </div>
    </div>
</div>

@endsection
