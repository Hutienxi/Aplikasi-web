@extends('layouts.app')
@section('content')
   <div class="container">
      <div class="row justify-content-center">
         <div class="col-md-10">
            <div class="card">
               <div class="card-header">DATA BARANG</div>
               <div class="card-body">
                  <div class = "row mb-5">
                     <div class = "col mb-6">
                        <a href="{{ route('main.create') }}"class= "btn btn-primary btn-sm">
                           Tambah Data
                        </a>
                     </div>
                  </div>
                  <table class="table table-striped">
                     <thead>
                        <tr>
                           <th>ID Barang</th>
                                    <th>Nama Barang </th>
                                    <th>Stock</th>   
                                    <th>Merk</th>
                                    <th>Kategori</th>
                                    <th>Tanggal Dibuat</th>
                                    <th>Tanggal Diganti</th>
                        </tr>
 </thead>
                     <tbody>
                        @foreach ($models as $item)
                           <tr>
                              <td>{{ $loop->iteration }}</td>
                                        <td>{{ $item->nama_barang }}</td>
                                        <td>{{ $item->stock }}</td>
                                        <td>{{ $item->merk }}</td>
                                        <td>{{ $item->kategori }}</td>
                                        <td>{{ $item->created_at }}</td>
                                        <td>{{ $item->updated_at }}</td>
                                        <td>
                                        {!! Form::open([
                                       'route' => ['main.destroy', $item->id],
                                       'method' => 'delete',
                                       'onsubmit' => 'return confirm("Yakin mau dihapus?")',
                                       ]) !!}
                                       <a href="{{ route('main.edit', $item->id) }}"
                                       class="btn btn-warning btn-sm ml-2">
                                       Edit
                                       </a>
                                       <button type="submit" class="btn btn-danger btn-sm ml-2">
                                       Hapus
                                       </button>
                                       {!! Form::close() !!}

                                       </td>

  

                           </tr>
                        @endforeach
                     </tbody>
                  </table>
                  {!! $models->links() !!}
               </div>
            </div>
         </div>
      </div>
   </div>
@endsection
