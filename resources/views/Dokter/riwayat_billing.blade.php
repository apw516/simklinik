<table id="tbriwayat" class="table table-sm table-bordered">
    <thead>
        <th>Nama </th>
        <th>harga</th>
        <th></th>
    </thead>
    <tbody>
        @foreach ($ts_layanan as $t )
            <tr>
                <td>{{ $t->nama_layanan}}</td>
                <td>Rp. {{ number_format($t->tarif, 0, ',', '.') }}</td>
                <td>
                    <button class="badge bg-danger retur" namalayanan="{{ $t->nama_layanan }}" layanandetail="{{$t->iddetail}}" idheader="{{$t->id_header}}"><i class="bi bi-x"></i></button>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
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
     $(".retur").on('click', function(event) {
        layanandetail = $(this).attr('layanandetail')
        idheader = $(this).attr('idheader')
        namalayanan = $(this).attr('namalayanan')
         Swal.fire({
                title: "Anda yakin ?"
                , text: "Data billing " + namalayanan +" akan diretur !"
                , icon: "question"
                , showCancelButton: true
                , confirmButtonColor: "#3085d6"
                , cancelButtonColor: "#d33"
                , confirmButtonText: "Ya retur ..."
            }).then((result) => {
                if (result.isConfirmed) {
                    
                }
            });
    });
</script>