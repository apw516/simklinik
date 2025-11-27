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
        <th>Status Layanan</th>
        <th>Status Order</th>
        <th></th>
    </thead>
    <tbody>
        @foreach ($detail as $d)
            <tr>
                <td>{{ $d->nama_layanan }}</td>
                <td>{{ $d->sediaan }}</td>
                <td>{{ $d->aturan_pakai }}</td>
                <td>{{ $d->jumlah_layanan }}</td>
                <td>{{ $d->stok_current }}</td>
                <td>{{ $d->kodebatch }}</td>
                <td>{{ $d->ed }}</td>
                <td>Rp. {{ number_format($d->total_tarif, 0, ',', '.') }}</td>
                <td>
                    @if ($d->jenistarif == 0)
                        Paket
                    @else
                        NON-Paket
                    @endif
                </td>
                <td>
                    @if ($d->status_layanan_detail == 1)
                        Aktif
                    @elseif($d->status_layanan_detail == 2)
                        Selesai
                    @elseif($d->status_layanan_detail == 3)
                        Batal
                    @endif
                </td>
                <td>
                    @if ($d->status_order == 0)
                        Belum diterima
                    @elseif($d->status_order == 1)
                        Sudah diterima
                    @endif
                </td>
                <td>
                    <button class="btn btn-warning detailbarang" iddetail="{{ $d->iddetail }}" data-bs-toggle="modal"
                        data-bs-target="#modaldetail"><i class="bi bi-pencil-square"></i></button>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
<!-- Modal -->
<div class="modal fade" id="modaldetail" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Detail barang</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="v_detail_barang">

                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                <button type="button" class="btn btn-primary" onclick="simpaneditan()"><i class="bi bi-download"></i>
                    Simpan Edit</button>
            </div>
        </div>
    </div>
</div>
<script>
    $(function() {
        $("#tabeldetailorder").DataTable({
            "responsive": true,
            "lengthChange": false,
            "autoWidth": false,
            "pageLength": 12,
            "searching": true,
            "ordering": false,
        })
    });
    $(".detailbarang").on('click', function(event) {
        iddetail = $(this).attr('iddetail')
        spinner = $('#loader')
        spinner.show();
        $.ajax({
            type: 'post',
            data: {
                _token: "{{ csrf_token() }}",
                iddetail
            },
            url: '<?= route('ambildetailbarangorder') ?>',
            success: function(response) {
                spinner.hide();
                $('.v_detail_barang').html(response);
            }
        });
    });

    function simpaneditan() {
        var data = $('.formeditorderan').serializeArray();
        spinner = $('#loader')
        spinner.show();
        $.ajax({
            async: true,
            type: 'post',
            dataType: 'json',
            data: {
                _token: "{{ csrf_token() }}",
                data: JSON.stringify(data),
            },
            url: '<?= route('simpaneditorderan') ?>',
            error: function(data) {
                spinner.hide()
                Swal.fire({
                    icon: 'error',
                    title: 'Ooops....',
                    text: 'Sepertinya ada masalah......',
                    footer: ''
                })
            },
            success: function(data) {
                spinner.hide()
                if (data.kode == 500) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oopss...',
                        text: data.message,
                        footer: ''
                    })
                } else {
                    Swal.fire({
                        icon: 'success',
                        title: 'OK',
                        text: data.message,
                        footer: ''
                    })
                    get_data_order()
                    $('#modaldetail').modal('toggle');
                }
            }
        });
    }
</script>
