<table class="table table-sm table-bordered" id="tabelpasien">
    <thead>
        <th>Nomor RM</th>
        <th>NIK</th>
        <th>Nama</th>
        <th>Jenis Kelamin</th>
        <th>Tanggal Lahir</th>
        <th>Alamat</th>
        <th></th>
    </thead>
    <tbody>
        @foreach ($pasien as $p )
        <tr>
            <td>{{ $p->no_rm}}</td>
            <td>{{ $p->NIK}}</td>
            <td>{{ $p->nama_pasien}}</td>
            <td>{{ $p->jenis_kelamin}}</td>
            <td>{{ $p->TGL_LAHIR}}</td>
            <td>{{ $p->alamat }}</td>
            <td>
                <button class="btn btn-warning"><i class="bi bi-pencil-square"></i></button>
                <button rm="{{ $p->no_rm }}" class="btn btn-success pendaftaran"><i class="bi bi-box-arrow-in-right"></i></button>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
<script>
    $(function() {
        $("#tabelpasien").DataTable({
            "responsive": true
            , "lengthChange": false
            , "autoWidth": false
            , "pageLength": 12
            , "searching": true
            , "ordering": false
        , })
    });
    $(".pendaftaran").on('click', function(event) {
        rm = $(this).attr('rm')
        spinner = $('#loader')
        spinner.show();
        $.ajax({
            type: 'post'
            , data: {
                _token: "{{ csrf_token() }}"
                , rm
            }
            , url: '<?= route('ambilformpendaftaran') ?>'
            , success: function(response) {
                spinner.hide();
                $('.v_utama').attr('hidden',true)
                $('.v_kedua').removeAttr('hidden',true)
                $('.v_kedua').html(response);
            }
        });
    });

</script>
