@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card">
                    <div class="card-header">EDIT BARANG</div>
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
                        {!! Form::submit($namaTombol, ['class' => 'btn btn-primary']) !!}
                        <a href="{{ route('main.index') }}"class= "btn btn-primary ">
                           Back
                        </a>
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
