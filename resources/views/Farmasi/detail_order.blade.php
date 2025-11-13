<div class="card">
    <div class="card-header">Detail Order Obat</div>
    <div class="card-body">
        <button class="btn btn-danger mb-3" onclick="kembali()"><i class="bi bi-backspace-fill"></i> Kembali</button>
        <table id="tabeldetailorder" class="table table-sm table-bordered" style="font-size: 15px">
            <thead>
                <th>Nama Barang</th>
                <th>Sediaan</th>
                <th>Aturan Pakai</th>
                <th>QTY order</th>
                <th>Stok tersedia</th>
                <th>Kode Batch</th>
                <th>expired date</th>
                <th>Grandtotal</th>
                <th>Jenis tarif</th>
                <th></th>
            </thead>
            <tbody>
                @foreach ($detail as $d )
                <tr>
                    <td>{{ $d->nama_layanan}}</td>
                    <td>{{ $d->sediaan}}</td>
                    <td>{{ $d->aturan_pakai}}</td>
                    <td>{{ $d->jumlah_layanan}}</td>
                    <td>{{ $d->stok_current}}</td>
                    <td>{{ $d->kodebatch}}</td>
                    <td>{{ $d->ed}}</td>
                    <td>Rp. {{ number_format($d->total_tarif, 0, ',', '.') }}</td>
                    <td>@if($d->jenistarif == 0) Paket @else NON-Paket @endif</td>
                    <th>
                        <button class="btn btn-warning"><i class="bi bi-pencil-square"></i></button>
                    </th>
                </tr>
                @endforeach
            </tbody>
        </table>
        <div class="card mt-2">
            <div class="card-header">Cari Obat ...</div>
            <div class="card-body">
                <div class="card">
                    <div class="card-header">Silahkan Pilih obat</div>
                    <div class="card-body">
                        
                    </div>
                </div>
                <div class="card mt-1">
                    <div class="card-header">List obat yang dipilih</div>
                    <div class="card-body">

                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="card-footer">
        <button class="btn btn-success mb-1"><i class="bi bi-download"></i> Simpan</button>
        <button class="btn btn-danger mb-1" onclick="kembali()"><i class="bi bi-backspace-fill"></i> Kembali</button>

    </div>
</div>
<script>
    $(function() {
        $("#tabeldetailorder").DataTable({
            "responsive": true
            , "lengthChange": false
            , "autoWidth": false
            , "pageLength": 12
            , "searching": true
            , "ordering": false
        , })
    });

    function kembali() {
        location.reload()
    }

</script>
