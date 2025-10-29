<table id="tabelriwayat" class="table table-sm">
    <thead>
        <th>Kode Pembayaran</th>
        <th>Tanggal entry</th>
        <th>No RM</th>
        <th>Nama Pasien</th>
        <th>Unit</th>
        <th>Total Tagihan</th>
        <th>Total Bayar</th>
        <th>Total Kembalian</th>
        <th></th>
    </thead>
    <tbody>
        @foreach ($datakasir as $d )
            <tr>
                <td>{{ $d->kode_pembayaran }}</td>
                <td>{{ $d->tgll }}</td>
                <td>{{ $d->no_rm}}</td>
                <td>{{ $d->no_rm}}</td>
                <td>{{ $d->unit}}</td>
                <td>Rp. {{ number_format($d->total_tagihan, 0, ',', '.') }}</td>
                <td>Rp. {{ number_format($d->uang_diterima, 0, ',', '.') }}</td>
                <td>Rp. {{ number_format($d->kembalian, 0, ',', '.') }}</td>
                <td>
                    <button class="badge bg-info text-dark"><i class="bi bi-printer"></i></button>
                    <button class="badge bg-warning text-dark"><i class="bi bi-list-columns-reverse"></i></button>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
<script>
    $(function() {
        $("#tabelriwayat").DataTable({
            "responsive": true
            , "lengthChange": false
            , "autoWidth": false
            , "pageLength": 12
            , "searching": true
            , "ordering": false
        , })
    });