<table id="tabelkunjungan" class="table table-sm table-bordered">
    <thead>
        <th>Tanggal Kunjungan</th>
        <th>nomor rm</th>
        <th>Nama Pasien</th>
        <th>Unit</th>
        <th></th>
    </thead>
    <tbody>
        @foreach ($dataheader as $d)
            <tr>
                <td width="20%">{{ $d->tanggalkunjungan }}</td>
                <td>{{ $d->no_rm }}</td>
                <td>{{ $d->namapasien }}</td>
                <td>{{ $d->unit }}</td>
                <td>
                    <button class="badge bg-success pilihpasien" kode_kunjungan="{{ $d->kode_kunjungan }}"><i
                            class="bi bi-receipt-cutoff"></i></button>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
<script>
    $(function() {
        $("#tabelkunjungan").DataTable({
            "responsive": true,
            "lengthChange": false,
            "autoWidth": false,
            "pageLength": 12,
            "searching": true,
            "ordering": false,
        })
    });
    $(".pilihpasien").on('click', function(event) {
        kodekunjungan = $(this).attr('kode_kunjungan')
        spinner = $('#loader')
        spinner.show();
        $.ajax({
            type: 'post',
            data: {
                _token: "{{ csrf_token() }}",
                kodekunjungan
            },
            url: '<?= route('ambildatabilling') ?>',
            success: function(response) {
                spinner.hide();
                $('.v_utama1').attr('hidden', true)
                $('.v_kedua2').removeAttr('hidden', true)
                $('.v_kedua2').html(response);
            }
        });
    });
