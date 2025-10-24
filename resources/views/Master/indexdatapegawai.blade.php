@extends('Template.Main')
@section('container')
<div class="app-content-header">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-6">
                <h3 class="mb-0">Data Pegawai</h3>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-end">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Data Pegawai</li>
                </ol>
            </div>
        </div>
    </div>
</div>
<div class="app-content">
    <div class="container-fluid">
        <button class="btn btn-success mb-3" data-bs-toggle="modal" data-bs-target="#modaltambahpegawai"><i class="bi bi-folder-plus mr-1 ml-1"></i> Tambah Pegawai</button>
        <div class="v_table_user">
            <div class="card">
                <div class="card-header">Tabel Pegawai</div>
                <div class="card-body">
                    <table id="tableuser" class="table table-sm table-bordered">
                        <thead>
                            <th>ID</th>
                            <th>NIK</th>
                            <th>Nama</th>
                            <th>Kontak</th>
                            <th>Jabatan</th>
                            <th>Status</th>
                            <th></th>
                        </thead>
                        <tbody>
                            @foreach ($datapegawai as $d )
                            <tr>
                                <td>{{ $d->id}}</td>
                                <td>{{ $d->NIK}}</td>
                                <td>{{ $d->nama}}</td>
                                <td>{{ $d->kontak}}</td>
                                <td>{{ $d->jabatan}}</td>
                                <td>@if($d->status == 1 ) Aktif @endif </td>
                                <td class="text-center">
                                    <button idpegawai="{{ $d->id }}" class="btn btn-warning btn-sm editpegawai" data-bs-toggle="modal" data-bs-target="#modaleditpegawai"><i class="bi bi-pencil-square"></i></button>
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
<div class="modal fade" id="modaltambahpegawai" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Data Pegawai</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label for="exampleFormControlInput1" class="form-label">NIK Pegawai</label>
                    <input type="text" class="form-control" id="nikpegawai" placeholder="Masukan nik pegawai ...">
                </div>
                <div class="mb-3">
                    <label for="exampleFormControlInput1" class="form-label">Nama Lengkap</label>
                    <input type="text" class="form-control" id="namalengkap" placeholder="Masukan nama lengkap beserta gelar ...">
                </div>
                <div class="mb-3">
                    <label for="exampleFormControlInput1" class="form-label">Nomor Kontak</label>
                    <input type="text" class="form-control" id="nomorkontak" placeholder="Masukan nomor kontak ...">
                </div>
                <div class="mb-3">
                    <label for="exampleFormControlInput1" class="form-label">Jabatan</label>
                    <select class="form-select" id="jabatan" aria-label="Default select example">
                        <option selected>Silahkan Pilih</option>
                        <option value="Admin">Admin</option>
                        <option value="Perawat">Perawat</option>
                        <option value="Bidan">Bidan</option>
                        <option value="Apoteker">Apoteker</option>
                    </select>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary simpanpegawai">Simpan</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="modaleditpegawai" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Edit Pegawai</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="v_form_edit_unit">

                </div>               
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary simpaneditpegawai">Simpan</button>
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
    $(".simpanpegawai").on('click', function(event) {
        nikpegawai = $('#nikpegawai').val()
        namalengkap = $('#namalengkap').val()
        nomorkontak = $('#nomorkontak').val()
        jabatan = $('#jabatan').val()
        spinner = $('#loader')
        spinner.show();
        $.ajax({
            async: true
            , type: 'post'
            , dataType: 'json'
            , data: {
                _token: "{{ csrf_token() }}"
                , nikpegawai , namalengkap,nomorkontak,jabatan
            , }
            , url: '<?= route('simpanpegawai') ?>'
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
    $(".editpegawai").on('click', function(event) {
            id = $(this).attr('idpegawai')
            spinner = $('#loader')
            spinner.show();
            $.ajax({
                type: 'post'
                , data: {
                    _token: "{{ csrf_token() }}"
                    , id
                }
                , url: '<?= route('ambildetailpegawai') ?>'
                , success: function(response) {
                    spinner.hide();
                    $('.v_form_edit_unit').html(response);
                }
            });
        });
</script>
@endsection
