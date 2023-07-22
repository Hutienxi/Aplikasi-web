<table>
    <thead>
        <tr>
            <th>No</th>
            <th>Nama Barang</th>
            <th>Total Beli</th>
            <th>Tanggal</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($data as $item)
            <tr class="p-3">
                <td><b>{{ $loop->iteration }}</b></td>
                <td><b>{{ \App\Models\Barang::find($item->id_barang)['nama_barang'] }}</b></td>
                <td><b>{{ $item->totalBeli }}</b></td>
                <td><b>{{ $item->tanggal }}</b></td>
            </tr>
        @endforeach
    </tbody>
</table>
