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
        <th>Status</th>
        <th></th>
    </thead>
    <tbody>
        @foreach ($datakasir as $d)
            <tr>
                <td>{{ $d->kode_pembayaran }}</td>
                <td>{{ $d->tgll }}</td>
                <td>{{ $d->no_rm }}</td>
                <td>{{ $d->namapasien }}</td>
                <td>{{ $d->unit }}</td>
                <td>Rp. {{ number_format($d->total_tagihan, 0, ',', '.') }}</td>
                <td>Rp. {{ number_format($d->uang_diterima, 0, ',', '.') }}</td>
                <td>Rp. {{ number_format($d->kembalian, 0, ',', '.') }}</td>
                <td>
                    @if($d->spk == 3) Retur @else Aktif @endif
                </td>
                <td>
                    <button class="badge bg-info text-dark"><i class="bi bi-printer"></i></button>
                    <button class="badge bg-warning text-dark detailpembayaran" data-bs-toggle="modal"
                        data-bs-target="#modaldetailbayar" idkasirheader="{{ $d->idkasirheader }}"><i
                            class="bi bi-list-columns-reverse"></i></button>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
<!-- Modal -->
<div class="modal fade" id="modaldetailbayar" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Detail pembayaran</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="v_detail_pembayaran">

                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<script>
    $(function() {
        $("#tabelriwayat").DataTable({
            "responsive": true,
            "lengthChange": false,
            "autoWidth": false,
            "pageLength": 12,
            "searching": true,
            "ordering": false,
        })
    });
    $(".detailpembayaran").on('click', function(event) {
        idkasirheader = $(this).attr('idkasirheader')
        spinner = $('#loader')
        spinner.show();
        $.ajax({
            type: 'post',
            data: {
                _token: "{{ csrf_token() }}",
                idkasirheader
            },
            url: '<?= route('ambildetailpembayaran') ?>',
            success: function(response) {
                spinner.hide();
                $('.v_detail_pembayaran').html(response);
            }
        });
    });
