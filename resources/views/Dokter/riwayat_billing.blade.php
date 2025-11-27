<table id="tbriwayat" class="table table-sm table-bordered">
    <thead>
        <th>Nama </th>
        <th>harga</th>
        <th>action</th>
    </thead>
    <tbody>
        @foreach ($ts_layanan as $t)
            <tr>
                <td>{{ $t->nama_layanan }}</td>
                <td>Rp. {{ number_format($t->tarif, 0, ',', '.') }}</td>
                <td>
                    @if ($t->status_pembayaran == 1)
                        Sudah dibayar
                    @else
                        <button class="badge bg-danger retur" namalayanan="{{ $t->nama_layanan }}"
                            layanandetail="{{ $t->iddetail }}" idheader="{{ $t->id_header }}"><i
                                class="bi bi-x"></i></button>
                    @endif
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
<script>
    $(function() {
        $("#tbriwayat").DataTable({
            "responsive": true,
            "lengthChange": false,
            "autoWidth": false,
            "pageLength": 12,
            "searching": true,
            "ordering": false,
        })
    });
    $(".retur").on('click', function(event) {
        layanandetail = $(this).attr('layanandetail')
        idheader = $(this).attr('idheader')
        namalayanan = $(this).attr('namalayanan')
        Swal.fire({
            title: "Anda yakin ?",
            text: "Data billing " + namalayanan + " akan diretur !",
            icon: "question",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Ya retur ..."
        }).then((result) => {
            if (result.isConfirmed) {
                batallayanan(layanandetail)
            }
        });
    });

    function batallayanan(id) {
        spinner = $('#loader')
        spinner.show();
        $.ajax({
            async: true,
            type: 'post',
            dataType: 'json',
            data: {
                _token: "{{ csrf_token() }}",
                id
            },
            url: '<?= route('batallayanan') ?>',
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
                    riwayatbilling()
                }
            }
        });
    }
</script>
