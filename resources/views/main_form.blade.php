@extends('layouts.template.master')
@section('content')
    <div class="container-fluid mt-5">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card">
                    <div class="card-header">TAMBAH BARANG</div>
                    <div class="card-body">
                        {!! Form::model($model, [
                            'method' => $method,
                            'route' => $route,
                        ]) !!}

                        <div class="form-group">
                            <label for="nama_barang">Nama Barang</label>
                            {!! Form::text('nama_barang',null, ['class' => 'form-control']) !!}
                            <span class="text-danger">{{ $errors->first('nama_barang') }}</span>
                        </div>

                        <div class="form-group mt-3">
                            <label for="merk">Merk</label>
                            {!! Form::text('merk', null, ['class' => 'form-control']) !!}
                            <span class="text-danger">{{ $errors->first('merk') }}</span>
                        </div>
                        <div class="form-group mt-3">
                            <label for="kategori">Kategori</label>
                            {!! Form::text('kategori', null, ['class' => 'form-control']) !!}
                            <span class="text-danger">{{ $errors->first('kategori') }}</span>
                        </div>
                        <br>
                        {!! Form::submit($namaTombol, ['class' => 'btn btn-success']) !!}
                        <a href="{{ route('main.index') }}"class= "btn btn-danger ">
                           Back
                        </a>
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
