@extends('Template.Main')
@section('container')
<div class="app-content-header">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-6">
                <h3 class="mb-0">Data User</h3>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-end">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Data User</li>
                </ol>
            </div>
        </div>
    </div>
</div>
<div class="app-content">
    <div class="container-fluid">
        <div class="v_table_user">
            <div class="card">
                <div class="card-header">Tabel User</div>
                <div class="card-body">
                    <table id="tableuser" class="table table-sm table-bordered">
                        <thead>
                            <th>ID</th>
                            <th>NIK PEGAWAI</th>
                            <th>Nama</th>
                            <th>Username</th>
                            <th>Unit Kerja</th>
                            <th>Hak Akses</th>
                            <th>status</th>
                            <th></th>
                        </thead>
                        <tbody>
                            @foreach ($datauser as $d )
                            <tr>
                                <td>{{ $d->id}}</td>
                                <td>{{ $d->nik_pegawai}}</td>
                                <td>{{ $d->nama}}</td>
                                <td>{{ $d->username}}</td>
                                <td>{{ $d->nama_unit}}</td>
                                <td>@if( $d->hak_akses == 1)Super Admin @endif </td>
                                <td>@if($d->is_activated == 1 ) Aktif @endif </td>
                                <td class="text-center">
                                    <button iduser="{{ $d->id }}" class="btn btn-warning btn-sm edituser"
                                        data-bs-toggle="modal" data-bs-target="#modaledituser"><i
                                            class="bi bi-pencil-square"></i></button>
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
<div class="modal fade" id="modaledituser" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Edit User</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="v_form_edit">

                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Simpan</button>
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
    $(".edituser").on('click', function(event) {
        id = $(this).attr('iduser')
        spinner = $('#loader')
        spinner.show();
        $.ajax({
            type: 'post'
            , data: {
                _token: "{{ csrf_token() }}"
                , id
            }
            , url: '<?= route('ambildetailuser') ?>'
            , success: function(response) {
                spinner.hide();
                $('.v_form_edit').html(response);
            }
        });
    });
</script>
@endsection