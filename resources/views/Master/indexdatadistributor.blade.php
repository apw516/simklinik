@extends('Template.Main')
@section('container')
<div class="app-content-header">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-6">
                <h3 class="mb-0">Data Distributor</h3>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-end">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Data Distributor</li>
                </ol>
            </div>
        </div>
    </div>
</div>
<div class="app-content">
    <div class="container-fluid">
        <div class="v_table_user">
            <button class="btn btn-success mb-3" data-bs-toggle="modal" data-bs-target="#modaltambahdistributor"><i class="bi bi-folder-plus"></i> Distributor</button>
            <div class="card">
                <div class="card-header">Tabel Distributor</div>
                <div class="card-body">
                    <table id="tableuser" class="table table-sm table-bordered">
                        <thead>
                            <th>ID</th>
                            <th>NAMA</th>
                            <th>ALAMAT</th>
                            <th>NO TELP</th>
                            <th>JENIS DISTRIBUTOR</th>
                            <th></th>
                        </thead>
                        <tbody>
                            @foreach ($data as $d )
                            <tr>
                                <td>{{ $d->id}}</td>
                                <td>{{ $d->nama_perusahaan}}</td>
                                <td>{{ $d->alamat}}</td>
                                <td>{{ $d->no_telp}}</td>
                                <td>{{ $d->jenis_distributor}}</td>
                                <td class="text-center">
                                    <button iddis="{{ $d->id }}" class="btn btn-warning btn-sm edituser" data-bs-toggle="modal" data-bs-target="#modaledituser"><i class="bi bi-pencil-square"></i></button>
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
<div class="modal fade" id="modaltambahdistributor" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Tambah Distributor</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form class="formdistributor" id="formdistributor">
                    <div class="form-group">
                        <label for="exampleInputEmail1">Nama Perusahaan</label>
                        <input type="text" placeholder="Masukan nama perusahaan ..." class="form-control" id="nama_perusahaan" name="nama_perusahaan" aria-describedby="emailHelp">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputPassword1">Nomor Telp</label>
                        <input type="text" placeholder="Masukan nomor telepon ..." class="form-control" id="no_telp" name="no_telp">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputPassword1">Jenis</label>
                         <select class="form-control" id="jenis_distributor" name="jenis_distributor">
                            <option value="Farmasi">Farmasi</option>
                            <option value="Atk">ATK</option>
                            <option value="Lainnya">Lainnya</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputPassword1">Alamat</label>
                        <textarea type="text" placeholder="Masukan alamat perusahaan ..." class="form-control" id="alamat" name="alamat"></textarea>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary simpandist">Simpan</button>
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
    $(".simpandist").on('click', function(event) {
        spinner = $('#loader')
        spinner.show();
        var data = $('.formdistributor').serializeArray();
        $.ajax({
            async: true,
            type: 'post',
            dataType: 'json',
            data: {
                _token: "{{ csrf_token() }}",
                data: JSON.stringify(data),
            },
            url: '<?= route('simpandistributor') ?>',
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
                    location.reload()
                    const myForm = document.getElementById('formdistributor');
                    myForm.reset();
                }
            }
        });
    });

</script>
@endsection
