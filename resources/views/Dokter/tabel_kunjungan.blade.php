<div class="card">
    <div class="card-header">Data Pasien</div>
    <div class="card-body">
        <table id="tabelkunjungan" class="table table-sm table-bordered">
            <thead>
                <th>Tanggal masuk</th>
                <th>Nomor rm</th>
                <th>Nama</th>
                <th>Unit</th>
                <th>Dokter</th>
                <th></th>
            </thead>
            <tbody>
                @foreach ($datakunjungan as $D )
                <tr>
                    <td>{{ $D->tanggalkunjungan}}</td>
                    <td>{{ $D->no_rm}}</td>
                    <td>{{ $D->namapasien}}</td>
                    <td>{{ $D->unit}}</td>
                    <td>{{ $D->namadokter}}</td>
                    <td>
                        <button class="badge bg-success pilihpasien" kodekunjungan="{{ $D->kode_kunjungan}}" rm="{{ $D->no_rm}}"><i class="bi bi-journal-arrow-up"></i></button>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
<script>
    $(function() {
        $("#tabelkunjungan").DataTable({
            "responsive": true
            , "lengthChange": false
            , "autoWidth": false
            , "pageLength": 12
            , "searching": true
            , "ordering": false
        , })
    });
 $(".pilihpasien").on('click', function(event) {
        rm = $(this).attr('rm')
        kodekunjungan = $(this).attr('kodekunjungan')
        spinner = $('#loader')
        spinner.show();
        $.ajax({
            type: 'post'
            , data: {
                _token: "{{ csrf_token() }}"
                , kodekunjungan,rm
            }
            , url: '<?= route('ambildetailpasiendokter') ?>'
            , success: function(response) {
                spinner.hide();
                $('.v_utama').attr('hidden',true)
                $('.v_kedua').removeAttr('hidden',true)
                $('.v_kedua').html(response);
            }
        });
    });
</script>
