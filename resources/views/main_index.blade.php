@extends('layouts.template.master')
@section('content')
   <div class="container">
      <div class="row justify-content-center">
         <div class="col-12">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Data Barang</h6>

                    <a href="{{ route('main.create') }}" class="btn btn-success btn-icon-split float-right">
                        <span class="icon text-white-50">
                            <i class="fas fa-plus"></i>
                        </span>
                        <span class="text">Tambah Data</span>
                    </a>
                </div>

                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                                <tr class="text-center">
                                    <th>ID Barang</th>
                                    <th>Nama Barang </th>
                                    <th>Stock</th>
                                    <th>Merk</th>
                                    <th>Kategori</th>
                                    <th>Tanggal Dibuat</th>
                                    <th>Tanggal Diganti</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($models as $item)
                                <tr class="text-center">
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $item->nama_barang }}</td>
                                        <td>{{ $item->stock }}</td>
                                        <td>{{ $item->merk }}</td>
                                        <td>{{ $item->kategori }}</td>
                                        <td>{{ $item->created_at }}</td>
                                        <td>{{ $item->updated_at }}</td>
                                        <td>
                                            <a href="{{ route('main.edit', ['id' => $item->id]) }}" class="btn btn-warning btn-sm ml-2">Edit</a>
                                            <a href="{{ route('main.destroy', ['id' => $item->id]) }}" onclick="confirm('ingin menghapus data ini?')" class="btn btn-danger btn-sm ml-2">Hapus</a>


                                        </td>
                                </tr>
                                @endforeach

                            </tbody>
                        </table>
                        {{-- {!! $models->links() !!} --}}
                    </div>
                </div>
            </div>
         </div>
      </div>
   </div>
@endsection
