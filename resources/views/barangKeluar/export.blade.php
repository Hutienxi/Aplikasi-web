<table>
    <thead>
        <tr>
            <th>No</th>
            <th>Nama Barang</th>
            <th>Merk</th>
            <th>Total Jual</th>
            <th>Tanggal</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($data as $item)
            <tr class="p-3">
                <td><b>{{ $loop->iteration }}</b></td>
                <td><b>{{ \App\Models\Barang::find($item->id_barang)['nama_barang'] }}</b></td>
                <td><b>{{ \App\Models\Barang::find($item->id_barang)['merk'] }}</b></td>
                <td><b>{{ $item->totalJual }}</b></td>
                <td><b>{{  Carbon\Carbon::parse($item->tanggal)->format('Y-m-d') }}</b></td>
            </tr>
        @endforeach
    </tbody>
</table>
