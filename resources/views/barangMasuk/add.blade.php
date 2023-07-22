@extends('layouts.template.master')
@section('content')
<div class="container-fluid mt-5">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">FORM BARANG MASUK</div>

                    <div class="card-body">
                        <a href="{{ route('barangMasuk') }}">
                            <button class="btn btn-danger float-end ">Kembali</button>
                        </a>
                        <br>
                        <form action="{{ route('barangMasuk.store') }}" method="POST">
                            @csrf
                            <div class="form-group mb-3">
                                <label for="">Nama Barang</label><span class="text-danger">*</span>
                                <select class="form-select" name="id_barang">
                                    <option selected>--Pilih Barang--</option>
                                        @foreach ($data as $val )
                                            <option value="{{ $val->id_barang }}">{{ $val->nama_barang }} | Stock : {{ $val->qty }} | Merk : {{ $val->merk }}</option>
                                        @endforeach

                                </select>
                            </div>

                            <div class="form-group mb-3">
                                <label for="">Qty</label><span class="text-danger">*</span>
                                <input type="text" name="qty" class="form-control">
                            </div>

                            <div class="form-group mb-3">
                                <label for="">Tanggal</label><span class="text-danger">*</span>
                                <input type="date" name="tanggal" class="form-control">
                            </div>

                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </form>

                    </div>
            </div>
        </div>
    </div>
</div>

@endsection
