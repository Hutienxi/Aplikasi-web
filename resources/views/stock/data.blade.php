@extends('layouts.template.master')
@section('content')
<div class="container-fluid mt-5">
    <div class="row justify-content-center">
       <div class="col-12 mx-5">
          <div class="card shadow">
              <div class="card-header py-3 margin-top-5">
                  <h4 class="m-0 font-weight-bold text-primary">Data Stock</h4>

                  <a href="{{ route('stock.create') }}" class="btn btn-success btn-icon-split float-end">
                      <span class="icon text-white-50">
                          <i class="fas fa-plus"></i>
                      </span>
                      <span class="text">Tambah Data</span>
                  </a>
              </div>

              <div class="card-body">
                  <div class="table-responsive">
                      <table id="dataTabel" class="table table-bordered" width="100%" cellspacing="0">
                          <thead>
                              <tr>

                                  <th class="text-center">No </th>
                                  <th class="text-center">Nama Barang </th>
                                  <th class="text-center">Merk </th>
                                  <th class="text-center">Qty</th>
                                  <th class="text-center">Tanggal Dibuat</th>
                                  <th class="text-center">Tanggal Diganti</th>
                                  {{-- <th class="text-center">Action</th> --}}


                              </tr>
                          </thead>
                          <tbody>

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


<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script>
<script src="https://cdn.datatables.net/1.11.4/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
<script src="https://cdn.datatables.net/1.11.4/js/dataTables.bootstrap5.min.js"></script>

<script type="text/javascript">
    $(document).ready(function() {
        run();
        var table

        function run() {
            table = $('#dataTabel').DataTable({
                processing: true,
                serverSide: true,
                // searchable: true
                ajax: "{{ route('stock.ajax') }}",
                columns: [
                    {
                        data: 'no',
                        className: 'text-center',
                        render: function (data, type, row, meta) {
                        // Menggunakan DT_RowIndex untuk nomor urut
                        return meta.row + 1;
                        },
                    },
                    {
                        data: 'id_barang',
                    },
                    {
                        data: 'merk',
                    },
                    {
                        data: 'qty'
                    },
                    {
                        data: 'created_at'
                    },
                    {
                        data: 'updated_at'
                    },
                    // {
                    //     data: 'action'
                    // },
                ],

            });
        }

    });
</script>

