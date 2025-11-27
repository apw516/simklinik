@if($detail[0]->spk == 3) <h5 class="mb-3 text-bold">Pembayaran sudah diretur !</h5> @endif
<table class="table table-sm table-bordered">
    <tr>
        <td>Kode Pembayaran</td>
        <td>: {{ $detail[0]->kode_pembayaran }} <button @if($detail[0]->spk == 3) disabled @endif class="btn btn-danger btn-sm" onclick="returpembayaran()"><i
                    class="bi bi-arrow-clockwise"></i></button></td>
    </tr>
    <tr>
        <td colspan="2">Detail</td>
    </tr>
    @foreach ($detail as $d)
        <tr>
            <td>{{ $d->nama_layanan }}</td>
            <td>Rp. {{ number_format($d->total_layanan, 0, ',', '.') }}</td>
        </tr>
    @endforeach
    <tr class="text-end">
        <td>Uang Bayar</td>
        <td>Rp. {{ number_format($detail[0]->uang_diterima, 0, ',', '.') }}</td>
    </tr>
    <tr class="text-end">
        <td>Grandtotal</td>
        <td>Rp. {{ number_format($detail[0]->total_tagihan, 0, ',', '.') }}</td>
    </tr>
    <tr class="text-end">
        <td>Kembalian</td>
        <td>Rp. {{ number_format($detail[0]->kembalian, 0, ',', '.') }}</td>
    </tr>
</table>
<input hidden type="text" value="{{ $idkasirheader }}" id="idpembayaran">
<style>
    .tooltip {
        z-index: 1151 !important;
    }
</style>
<script>
    function returpembayaran() {
        Swal.fire({
            title: "Anda yakin ?",
            text: "Data pembayaran akan diretur !",
            icon: "question",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Ya retur ..."
        }).then((result) => {
            if (result.isConfirmed) {
                retursemuapembayaran2()
            }
        });
    }

    function retursemuapembayaran2() {
        idpembayaran = $('#idpembayaran').val()
        spinner = $('#loader')
        spinner.show();
        $.ajax({
            async: true,
            type: 'post',
            dataType: 'json',
            data: {
                _token: "{{ csrf_token() }}",
                idpembayaran
            },
            url: '<?= route('batalpembayaran') ?>',
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
                    location.reload()
                }
            }
        });
    }
</script>
