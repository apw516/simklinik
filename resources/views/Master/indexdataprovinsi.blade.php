@extends('Template.Main')
@section('container')
<div class="app-content-header">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-6">
                <h3 class="mb-0">Data Lokasi</h3>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-end">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Data Lokasi</li>
                </ol>
            </div>
        </div>
    </div>
</div>
<div class="app-content">
    <div class="container-fluid">
        <div class="btn-group mb-3" role="group" aria-label="Basic example">
            <button type="button" class="btn btn-primary">Data Provinsi</button>
            <button type="button" class="btn btn-primary">Data Kabupaten</button>
            <button type="button" class="btn btn-primary">Data Kecamatan</button>
            <button type="button" class="btn btn-primary">Data Desa</button>
        </div>
        <div class="v_table_user">
            <div class="card">
                <div class="card-header">Tabel Provinsi</div>
                <div class="card-body">
                    <table id="tableprovinsi" class="table table-sm table-bordered">
                        <thead>
                            <th>ID</th>
                            <th>CODE</th>
                            <th>BPS CODE</th>
                            <th>PARENT CODE</th>
                            <th>NAME</th>
                            <th class="text-center">TAMBAH DATA</th>
                            {{-- <th class="text-center">LIHAT DATA</th> --}}
                        </thead>
                        <tbody>
                            @foreach ($mt_provinsi as $d )
                            <tr>
                                <td>{{ $d->id}}</td>
                                <td>{{ $d->code}}</td>
                                <td>{{ $d->bps_code}}</td>
                                <td>{{ $d->parent_code}}</td>
                                <td>{{ $d->name}}</td>
                                <td class="text-center">
                                    <button idprov="{{ $d->code }}" class="btn btn-success btn-sm downloadkabupaten"><i class="bi bi-plus"></i> Kab / Kota</button>
                                    <button idprov="{{ $d->bps_code }}" class="btn btn-success btn-sm getkecamatan" data-bs-toggle="modal" data-bs-target="#modaladdkecamatan"><i class="bi bi-plus"></i> Kecamatan</button>
                                    <button idprov="{{ $d->bps_code }}" class="btn btn-success btn-sm getdesa" data-bs-toggle="modal" data-bs-target="#modaladddesa"><i class="bi bi-plus"></i> Desa</button>
                                </td>
                                {{-- <td class="text-center">
                                    <button idprov="{{ $d->code }}" class="btn btn-info btn-sm downloadkabupaten"><i class="bi bi-eye mr-1"></i> Kab / Kota</button>
                                <button idprov="{{ $d->bps_code }}" class="btn btn-info btn-sm getkecamatan" data-bs-toggle="modal" data-bs-target="#modaladdkecamatan"><i class="bi bi-eye mr-1"></i> Kecamatan</button>
                                <button idprov="{{ $d->bps_code }}" class="btn btn-info btn-sm getdesa" data-bs-toggle="modal" data-bs-target="#modaladddesa"><i class="bi bi-eye mr-1"></i> Desa</button>
                                </td> --}}
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="modaladdkecamatan" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">ADD Kecamatan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="form_add_kecamatan">

                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" onclick="downloadkecamatan()">Simpan</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="modaladddesa" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">ADD Desa</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="v_form_add_desa">

                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" onclick="downloaddesa()">Simpan</button>
            </div>
        </div>
    </div>
</div>
<script>
    $(function() {
        $("#tableprovinsi").DataTable({
            "responsive": true
            , "lengthChange": false
            , "autoWidth": false
            , "pageLength": 8
            , "searching": true
            , "ordering": false
        , })
    });
    $(".downloadkabupaten").on('click', function(event) {
        idprov = $(this).attr('idprov')
        spinner = $('#loader')
        spinner.show();
        $.ajax({
            async: true
            , type: 'post'
            , dataType: 'json'
            , data: {
                _token: "{{ csrf_token() }}"
                , idprov
            , }
            , url: '<?= route('downloadkabupaten') ?>'
            , error: function(data) {
                spinner.hide()
                Swal.fire({
                    icon: 'error'
                    , title: 'Ooops....'
                    , text: 'Sepertinya ada masalah......'
                    , footer: ''
                })
            }
            , success: function(data) {
                spinner.hide()
                if (data.kode == 500) {
                    Swal.fire({
                        icon: 'error'
                        , title: 'Oopss...'
                        , text: data.message
                        , footer: ''
                    })
                } else {
                    Swal.fire({
                        icon: 'success'
                        , title: 'OK'
                        , text: data.message
                        , footer: ''
                    })
                    location.reload()
                }
            }
        });
    });
    $(".getkecamatan").on('click', function(event) {
        id = $(this).attr('idprov')
        spinner = $('#loader')
        spinner.show();
        $.ajax({
            type: 'post'
            , data: {
                _token: "{{ csrf_token() }}"
                , id
            }
            , url: '<?= route('ambilformaddkecamatan') ?>'
            , success: function(response) {
                spinner.hide();
                $('.form_add_kecamatan').html(response);
            }
        });
    });
    $(".getdesa").on('click', function(event) {
        id = $(this).attr('idprov')
        spinner = $('#loader')
        spinner.show();
        $.ajax({
            type: 'post'
            , data: {
                _token: "{{ csrf_token() }}"
                , id
            }
            , url: '<?= route('ambil_form_desa') ?>'
            , success: function(response) {
                spinner.hide();
                $('.v_form_add_desa').html(response);
            }
        });
    });

    function downloadkecamatan() {
        kodekabupaten = $('#kodekabupaten').val()
        spinner = $('#loader')
        spinner.show();
        $.ajax({
            async: true
            , type: 'post'
            , dataType: 'json'
            , data: {
                _token: "{{ csrf_token() }}"
                , kodekabupaten
            , }
            , url: '<?= route('downloadkecamatan') ?>'
            , error: function(data) {
                spinner.hide()
                Swal.fire({
                    icon: 'error'
                    , title: 'Ooops....'
                    , text: 'Sepertinya ada masalah......'
                    , footer: ''
                })
            }
            , success: function(data) {
                spinner.hide()
                if (data.kode == 500) {
                    Swal.fire({
                        icon: 'error'
                        , title: 'Oopss...'
                        , text: data.message
                        , footer: ''
                    })
                } else {
                    Swal.fire({
                        icon: 'success'
                        , title: 'OK'
                        , text: data.message
                        , footer: ''
                    })
                }
            }
        });
    }

    function downloaddesa() {
        kodekecamatan = $('#kodekecamatan').val()
        spinner = $('#loader')
        spinner.show();
        $.ajax({
            async: true
            , type: 'post'
            , dataType: 'json'
            , data: {
                _token: "{{ csrf_token() }}"
                , kodekecamatan
            , }
            , url: '<?= route('downloaddesa') ?>'
            , error: function(data) {
                spinner.hide()
                Swal.fire({
                    icon: 'error'
                    , title: 'Ooops....'
                    , text: 'Sepertinya ada masalah......'
                    , footer: ''
                })
            }
            , success: function(data) {
                spinner.hide()
                if (data.kode == 500) {
                    Swal.fire({
                        icon: 'error'
                        , title: 'Oopss...'
                        , text: data.message
                        , footer: ''
                    })
                } else {
                    Swal.fire({
                        icon: 'success'
                        , title: 'OK'
                        , text: data.message
                        , footer: ''
                    })
                }
            }
        });
    }

</script>
@endsection
