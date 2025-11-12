<div class="card">
    <div class="card-header">Hasil Pemeriksaan</div>
    <div class="card-body">
        <table class="table table-sm">
            <tr>
                <td>Tekanan darah : {{ $ts_kunjungan[0]->tekanandarah }}</td>
                <td>Suhu Tubuh: {{ $ts_kunjungan[0]->suhutubuh }}</td>
                <td>Keluhan Utama: {{ $ts_kunjungan[0]->keluhanpasien }}</td>
            </tr>
            <tr>
                <td>Subject :  {{ $ts_kunjungan[0]->subject }}</td>
                <td>Object :  {{ $ts_kunjungan[0]->object }}</td>
            </tr>
            <tr>
                <td>Diagnosa Primer :  {{ $ts_kunjungan[0]->diagnosaprimer }} , {{ $ts_kunjungan[0]->kodediagnosaprimer}}</td>
                <td>Diagnosa Sekunder :  {{ $ts_kunjungan[0]->diagnosasekunder }} , {{ $ts_kunjungan[0]->kodediagnosasekunder}}</td>
            </tr>
            <tr>
                <td>Hasil Pemeriksaan :  {{ $ts_kunjungan[0]->hasilpemeriksaan }}</td>
                <td>Planning :  {{ $ts_kunjungan[0]->planning }}</td>
            </tr>
        </table>
    </div>
</div>
<div class="card mt-2">
    <div class="card-header">Billing Pasien</div>
    <div class="card-body">
        <table id="tbriwayat" class="table table-sm table-bordered">
            <thead>
                <th>Nama </th>
                <th>harga</th>
                <th>Status</th>
            </thead>
            <tbody>
                @foreach ($ts_layanan as $t )
                    <tr>
                        <td>{{ $t->nama_layanan}}</td>
                        <td>Rp. {{ number_format($t->tarif, 0, ',', '.') }}</td>
                        <td>@if($t->status_pembayaran == 1) Sudah dibayar @elseif($t->status_pembayaran == 0) Belum dibayar @endif </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
<script>
    $(function() {
        $("#tbriwayat").DataTable({
            "responsive": true
            , "lengthChange": false
            , "autoWidth": false
            , "pageLength": 12
            , "searching": true
            , "ordering": false
        , })
    });
</script>