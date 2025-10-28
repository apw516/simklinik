@extends('Template.Main')
@section('container')
<div class="app-content-header">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-6">
                <h3 class="mb-0">Data Tarif</h3>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-end">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Data Tarif</li>
                </ol>
            </div>
        </div>
    </div>
</div>
<div class="app-content">
    <div class="container-fluid">
        <button class="btn btn-success mb-3" data-bs-toggle="modal" data-bs-target="#modaltambahtarif"><i class="bi bi-folder-plus mr-1 ml-1"></i> Tambah Tarif</button>
          <div class="v_table_user">
            <div class="card">
                <div class="card-header">Tabel Tarif</div>
                <div class="card-body">
                    <table id="tabletarif" class="table table-sm table-bordered">
                        <thead>
                            <th>Kode Tarif</th>
                            <th>Nama Tarif</th>
                            <th>Jenis</th>
                            <th>harga</th>
                            <th>Status</th>
                            <th></th>
                        </thead>
                        <tbody>
                            @foreach ($datatarif as $d )
                            <tr>
                                <td>{{ $d->id}}</td>
                                <td>{{ $d->nama}}</td>
                                <td>{{ $d->jenis}}</td>
                                <td>Rp. {{ number_format($d->harga, 0, ',', '.') }}</td>
                                <td>@if($d->status == 1 ) Aktif @endif </td>
                                <td class="text-center">
                                    <button idtarif="{{ $d->id }}" class="btn btn-warning btn-sm edittarif" data-bs-toggle="modal" data-bs-target="#modaledittarif"><i class="bi bi-pencil-square"></i></button>
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
<div class="modal fade" id="modaltambahtarif" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Data Tarif</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label for="exampleFormControlInput1" class="form-label">Nama Tarif</label>
                    <input type="text" class="form-control" id="nama" placeholder="Masukan nama tarif ...">
                </div>
                <div class="mb-3">
                    <label for="exampleFormControlInput1" class="form-label">Jenis Tarif</label>
                    <select class="form-select" id="jenis" aria-label="Default select example">
                        <option selected>Silahkan Pilih</option>
                        <option value="RJ">Rawat Jalan</option>
                        <option value="RI">Rawat Inap</option>
                        <option value="LB">Laboratorium</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="exampleFormControlInput1" class="form-label">Harga</label>
                    <input type="text" class="form-control" id="harga" placeholder="Masukan harga ...">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary simpantarif">Simpan</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="modaledittarif" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Edit Tarif</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="v_form_edit_tarif">

                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary simpanedittarif">Simpan</button>
            </div>
        </div>
    </div>
</div>
<script>
    $(function() {
        $("#tabletarif").DataTable({
            "responsive": true
            , "lengthChange": false
            , "autoWidth": false
            , "pageLength": 12
            , "searching": true
            , "ordering": false
        , })
    });
    $(".simpantarif").on('click', function(event) {
        nama = $('#nama').val()
        jenis = $('#jenis').val()
        harga = $('#harga').val()
        spinner = $('#loader')
        spinner.show();
        $.ajax({
            async: true
            , type: 'post'
            , dataType: 'json'
            , data: {
                _token: "{{ csrf_token() }}"
                , nama
                , jenis
                , harga
            , }
            , url: '<?= route('simpantarif') ?>'
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
    $(".edittarif").on('click', function(event) {
        id = $(this).attr('idtarif')
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
                $('.v_form_edit_tarif').html(response);
            }
        });
    });

</script>
@endsection
