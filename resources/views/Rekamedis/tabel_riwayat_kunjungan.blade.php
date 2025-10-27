<table id="tabelriwayatkunjungan" class="table table-sm table-bordered" style="font-size: 12px">
    <thead>
        <th>Kunjungan ke - </th>
        <th>Unit</th>
        <th>Dokter</th>
        <th>Tanggal kunjungan</th>
        <th>Status</th>
    </thead>
    <tbody>
        @foreach ($riwayat as $r )
        <tr>
            <td>@if($r->statuskunjungan == 1) <button unit="{{ $r->unit }}" tgl="{{$r->tanggalkunjungan}}" kodekunjungan="{{ $r->kode_kunjungan }}" class="badge bg-danger btn-sm batalkunjungan"> x </button> @endif {{ $r->counter}}</td>
            <td>{{ $r->unit}}</td>
            <td>{{ $r->namadokter}}</td>
            <td>{{ $r->tanggalkunjungan}}</td>
            <td>@if($r->statuskunjungan == 1)<button unit="{{ $r->unit }}" tgl="{{$r->tanggalkunjungan}}"  kodekunjungan="{{ $r->kode_kunjungan }}" class="badge bg-success btn-sm tutupkunjungan"> v </button> Aktif @elseif($r->statuskunjungan == 2) Selesai @endif</td>
        </tr>
        @endforeach
    </tbody>
</table>
<script>
    $(function() {
        $("#tabelriwayatkunjungan").DataTable({
            "responsive": true
            , "lengthChange": false
            , "autoWidth": false
            , "pageLength": 12
            , "searching": true
            , "ordering": false
        , })
    });
    $(".batalkunjungan").on('click', function(event) {
        kodekunjungan = $(this).attr('kodekunjungan')
        unit = $(this).attr('unit')
        tgl = $(this).attr('tgl')
        status = 3
        Swal.fire({
            title: "Anda yakin ?"
            , text: "Kunjungan ke "+ unit + " tanggal "+ tgl +" akan dibatalkan !"
            , icon: "error"
            , showCancelButton: true
            , confirmButtonColor: "#3085d6"
            , cancelButtonColor: "#d33"
            , confirmButtonText: "Ya batalkan ..."
        }).then((result) => {
            if (result.isConfirmed) {
                batalkunjungan(status,kodekunjungan)
            }
        });
    });
    $(".tutupkunjungan").on('click', function(event) {
        kodekunjungan = $(this).attr('kodekunjungan')
        unit = $(this).attr('unit')
        tgl = $(this).attr('tgl')
        status = 2
        Swal.fire({
            title: "Anda yakin ?"
            , text: "Kunjungan ke "+ unit + " tanggal "+ tgl +" akan ditutup !"
            , icon: "question"
            , showCancelButton: true
            , confirmButtonColor: "#3085d6"
            , cancelButtonColor: "#d33"
            , confirmButtonText: "Ya tutup kunjungan ..."
        }).then((result) => {
            if (result.isConfirmed) {
                batalkunjungan(status,kodekunjungan)
            }
        });
    });
    function batalkunjungan(status,kodekunjungan){
        spinner = $('#loader')
        spinner.show();
        $.ajax({
            async: true,
            type: 'post',
            dataType: 'json',
            data: {
                _token: "{{ csrf_token() }}",
                status,kodekunjungan
            },
            url: '<?= route('batalkunjungan') ?>',
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
                    ambilriwayatkunjungan()
                }
            }
        });
    }
