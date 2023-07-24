<!DOCTYPE html>
<html>
<head>
    <title>Laporan Barang Keluar</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

     <style>
        .cv-text {
            position: absolute;
            top: 0;
            right: 0;
        }

        .alamat {
            font-size: 9px; /* Ubah ukuran font sesuai preferensi */
        }

        /* Custom CSS untuk mengatur tata letak */
        .header {
            display: flex;
            justify-content: space-between;
        }

        .title {
            margin: 0;
            font-size: 24px; /* Ubah ukuran font sesuai preferensi */
            font-weight: bold;
        }
    </style>

</head>

<body>
     <div class="header">
        <h1 class="title">{{ $title }}</h1>
        <p class="cv-text">Periode : {{ Carbon\Carbon::parse($startDate)->format('Y-m-d') }} - {{ Carbon\Carbon::parse($endDate)->format('Y-m-d') }}</p>

    </div>
    <p >CV. Tunas Jaya Abadi</p>
    <p class="alamat">Jalan Kol Pol M.Thaher No. 10, RT. 14, Kelurahan Pakuan Baru,  Kecamatan Jambi Selatan</p>

    <table class="table table-bordered">
        <tr>
            <th class="text-center">No</th>
            <th class="text-center">Nama Barang</th>
            <th class="text-center">Merk</th>
            <th class="text-center">Total Jual</th>
            <th class="text-center">Tanggal</th>

        </tr>
        @foreach($join as $item)
            <tr class="p-3">
                <td class="text-center"><b>{{ $loop->iteration }}</b></td>
                <td class="text-center"><b>{{ \App\Models\Barang::find($item->id_barang)['nama_barang'] }}</b></td>
                <td class="text-center"><b>{{ \App\Models\Barang::find($item->id_barang)['merk'] }}</b></td>
                <td class="text-center"><b>{{ $item->totalJual }}</b></td>
                <td class="text-center"><b>{{  Carbon\Carbon::parse($item->tanggal)->format('Y-m-d') }}</b></td>

            </tr>
        @endforeach
    </table>
</body>
</html>
