@extends('Template.Main')
@section('container')
<div class="app-content-header">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-6">
                <h3 class="mb-0">Data Unit</h3>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-end">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Data Unit</li>
                </ol>
            </div>
        </div>
    </div>
</div>
<div class="app-content">
    <div class="container-fluid">
        <button class="btn btn-success mb-3" data-bs-toggle="modal" data-bs-target="#modaltambahunit"><i class="bi bi-folder-plus mr-1 ml-1"></i> Tambah Unit</button>
        <div class="v_table_user">
            <div class="card">
                <div class="card-header">Tabel Unit</div>
                <div class="card-body">
                    <table id="tableuser" class="table table-sm table-bordered">
                        <thead>
                            <th>Kode Unit</th>
                            <th>Nama Unit</th>
                            <th>Jenis</th>
                            <th>Status</th>
                            <th></th>
                        </thead>
                        <tbody>
                            @foreach ($dataunit as $d )
                            <tr>
                                <td>{{ $d->kode_unit}}</td>
                                <td>{{ $d->nama}}</td>
                                <td>{{ $d->jenis}}</td>
                                <td>@if($d->status == 1 ) Aktif @endif </td>
                                <td class="text-center">
                                    <button kodeunit="{{ $d->kode_unit }}" class="btn btn-warning btn-sm editunit" data-bs-toggle="modal" data-bs-target="#modaleditunit"><i class="bi bi-pencil-square"></i></button>
                                </td>
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
<div class="modal fade" id="modaltambahunit" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Data Unit</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label for="exampleFormControlInput1" class="form-label">Nama Unit</label>
                    <input type="text" class="form-control" id="namaunit" placeholder="Masukan nama unit ...">
                </div>
                <div class="mb-3">
                    <label for="exampleFormControlInput1" class="form-label">Jenis Unit</label>
                    <select class="form-select" id="jenisunit" aria-label="Default select example">
                        <option selected>Silahkan Pilih</option>
                        <option value="RJ">Rawat Jalan</option>
                        <option value="RI">Rawat Inap</option>
                        <option value="AD">Administrasi</option>
                    </select>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary simpanunit">Simpan</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="modaleditunit" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Edit Unit</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="v_form_edit_unit">

                </div>               
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary simpanunit">Simpan</button>
            </div>
        </div>
    </div>
</div>
<script>
    $(function() {
        $("#tableuser").DataTable({
            "responsive": true
            , "lengthChange": false
            , "autoWidth": false
            , "pageLength": 12
            , "searching": true
            , "ordering": false
        , })
    });
    $(".simpanunit").on('click', function(event) {
        nama = $('#namaunit').val()
        jenis = $('#jenisunit').val()
        spinner = $('#loader')
        spinner.show();
        $.ajax({
            async: true
            , type: 'post'
            , dataType: 'json'
            , data: {
                _token: "{{ csrf_token() }}"
                , jenis , nama
            , }
            , url: '<?= route('simpanunit') ?>'
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
    $(".editunit").on('click', function(event) {
            id = $(this).attr('kodeunit')
            spinner = $('#loader')
            spinner.show();
            $.ajax({
                type: 'post'
                , data: {
                    _token: "{{ csrf_token() }}"
                    , id
                }
                , url: '<?= route('ambildetailunit') ?>'
                , success: function(response) {
                    spinner.hide();
                    $('.v_form_edit_unit').html(response);
                }
            });
        });
</script>
@endsection
