@extends('layouts.template.master')
@section('content')
<div class="container-fluid mt-5">
    <div class="row justify-content-center">
       <div class="col-12 mx-5">
          <div class="card shadow">
              <div class="card-header py-3 margin-top-5">
                  <h4 class="m-0 font-weight-bold text-primary">Barang Masuk</h4>

                  <a href="#" class="btn btn-primary btn-icon-split float-end mx-2" onclick="exportExcel()">
                      <span class="icon text-white-50">
                          <i class="fas fa-print"></i>
                      </span>
                      <span class="text">Export</span>
                  </a>

                  <a href="{{ route('barangMasuk.create') }}" class="btn btn-success btn-icon-split float-end">
                      <span class="icon text-white-50">
                          <i class="fas fa-plus"></i>
                      </span>
                      <span class="text">Tambah Data</span>
                  </a>

                  <button type="button" {{-- data-modal-toggle="defaultModal" --}} >
                    <svg class="w-10 h-fit fill-blue-600" viewBox="0 0 24 24">
                        <path
                            d="M6,2C4.89,2 4,2.9 4,4V20A2,2 0 0,0 6,22H18A2,2 0 0,0 20,20V8L14,2M13,3.5L18.5,9H13M8.93,12.22H16V19.29L13.88,17.17L11.05,20L8.22,17.17L11.05,14.35" />
                    </svg>
                </button>
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
                                  <th class="text-center">Tanggal</th>
                                  <th class="text-center">Total Qty</th>
                                  {{-- <th class="text-center">Updated at</th> --}}
                                  <th class="text-center">Action</th>

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
                ajax: "{{ route('barangMasuk.ajax') }}",
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
                        data: 'tanggal'
                    },
                    {
                        data: 'total'
                    },
                    // {
                    //     data: 'updated_at'
                    // },
                    {
                        data: 'action'
                    },
                ],

            });
        }

    });
</script>


<script type="text/javascript">
    function exportExcel() {
        Swal.fire({
                title: 'Export Excel',
                html: `
                        <label>Tanggal Mulai</label>
                        <input type="date" id="startDate" name="startDate" class="swal2-input">
                        <label>Tanggal Akhir</label>
                        <input type="date" id="endDate" name="endDate" class="swal2-input">
                    `,

                confirmButtonText: 'Export',
                focusConfirm: false,
            })
            .then((result) => {
                var dari = $('#startDate').val();
                var ke = $('#endDate').val();
                var kategori = $('#kategori').val();

                window.location.href = "{{ route('barangMasuk.export') }}?startDate=" + dari + "&endDate=" + ke +
                    "&kategori=" + kategori;
            })
    }
</script>