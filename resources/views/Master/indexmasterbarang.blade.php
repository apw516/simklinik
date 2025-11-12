@extends('Template.Main')
@section('container')
<div class="app-content-header">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-6">
                <h3 class="mb-0">Master Barang</h3>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-end">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Master Barang</li>
                </ol>
            </div>
        </div>
    </div>
</div>
<div class="app-content">
    <div class="container-fluid">
        <div hidden class="v_add_master_barang">
            <button class="btn btn-danger mb-3" onclick="kembali()"><i class="bi bi-backspace"></i> Kembali</button>
            <div class="card mb-2">
                <div class="card-header">Form add master barang</div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header">Pilih Distributor</div>
                                <div class="card-body">
                                    <table class="table table-sm fs-6" id="tabledis">
                                        <thead>
                                            <th>Nama</th>
                                            <th>No Telp</th>
                                            <th>Alamat</th>
                                            <th>Jenis</th>
                                            <th>Action</th>
                                        </thead>
                                        <tbody>
                                            @foreach ($dis as $d )
                                            <tr>
                                                <td>{{ $d->nama_perusahaan}}</td>
                                                <td>{{ $d->no_telp}}</td>
                                                <td>{{ $d->alamat}}</td>
                                                <td>{{ $d->jenis_distributor}}</td>
                                                <td>
                                                    <button class="badge bg-success pilidist" iddist="{{ $d->id }}"
                                                        namadist="{{ $d->nama_perusahaan }}"
                                                        jenis="{{ $d->jenis_distributor }}"><i
                                                            class="bi bi-check2-square"></i></button>
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 mt-2">
                            <div class="card">
                                <div class="card-header">Data Barang</div>
                                <div class="card-body">
                                    <form class="arraydist">
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Nama Distributor / Perusahaan</label>
                                            <input readonly type="email" class="form-control" name="namadistributor"
                                                id="namadistributor" aria-describedby="emailHelp">
                                            <input hidden readonly type="email" class="form-control" name="iddist"
                                                id="iddist" aria-describedby="emailHelp">
                                        </div>
                                        <div class="form-group mt-2">
                                            <label for="exampleInputPassword1">Jenis</label>
                                            <input readonly type="text" name="jenis" class="form-control" id="jenis">
                                        </div>
                                    </form>
                                    <input hidden type="text" value="" id="jumlahform">
                                    <button class="btn btn-success mt-4 mb-4" onclick="addform()"><i
                                            class="bi bi-node-plus"></i> Barang</button>
                                    <form action="" method="post" class="arraybarang">
                                        <div class="formobatfarmasi2">

                                        </div>
                                    </form>
                                </div>
                                <div class="card-footer">
                                    <button class="btn btn-success simpanmasterbarang">Simpan</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="v_data_master">
            <button class="btn btn-success mb-3" onclick="go()"><i class="bi bi-folder-plus"></i> Master Barang</button>
            <div class="card">
                <div class="card-header">Data Barang</div>
                <div class="card-body">
                    <table class="table table-sm" id="tabel_master_barang">
                        <thead>
                            <th>Nama Barang</th>
                            <th>Nama Generik</th>
                            <th>Distributor</th>
                            <th>Jenis Barang</th>
                            <th>Satuan</th>
                            <th>isi</th>
                            <th>Sediaan</th>
                            <th>Keterangan</th>
                            <th></th>
                        </thead>
                        <tbody>
                            @foreach ($mt_barang as $b )
                                <tr>
                                    <td>{{ $b->namabarang}}</td>
                                    <td>{{ $b->namagenerik}}</td>
                                    <td>{{ $b->nama_distributo}}</td>
                                    <td>{{ $b->jenisbarang}}</td>
                                    <td>{{ $b->satuan}}</td>
                                    <td>{{ $b->isi}}</td>
                                    <td>{{ $b->sediaan}}</td>
                                    <td>{{ $b->keterangan}}</td>
                                    <td>
                                        <button class="badge text-dark bg-warning"><i class="bi bi-pencil-square"></i></button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="card-footer">
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="modaltambahdistributor" tabindex="-1" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
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
                        <input type="text" placeholder="Masukan nama perusahaan ..." class="form-control"
                            id="nama_perusahaan" name="nama_perusahaan" aria-describedby="emailHelp">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputPassword1">Nomor Telp</label>
                        <input type="text" placeholder="Masukan nomor telepon ..." class="form-control" id="no_telp"
                            name="no_telp">
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
                        <textarea type="text" placeholder="Masukan alamat perusahaan ..." class="form-control"
                            id="alamat" name="alamat"></textarea>
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
        $("#tabel_master_barang").DataTable({
            "responsive": true
            , "lengthChange": false
            , "autoWidth": false
            , "pageLength": 12
            , "searching": true
            , "ordering": false
        , })
    });
    $(function() {
        $("#tabledis").DataTable({
            "responsive": true
            , "lengthChange": false
            , "autoWidth": false
            , "pageLength": 12
            , "searching": true
            , "ordering": false
        , })
    });

    $(".pilidist").on('click', function(event) {
        iddist = $(this).attr('iddist')
        namadist = $(this).attr('namadist')
        jenis = $(this).attr('jenis')

        $('#namadistributor').val(namadist)
        $('#jenis').val(jenis)
        $('#iddist').val(iddist)
    });

    $(".simpanmasterbarang").on('click', function(event) {
        Swal.fire({
            title: "Anda yakin ?",
            text: "Data barang akan disimpan!",
            icon: "question",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Ya Simpan ..."
            }).then((result) => {
            if (result.isConfirmed) {
                var data1 = $('.arraydist').serializeArray();
        var data2 = $('.arraybarang').serializeArray();
        spinner = $('#loader')
        spinner.show();
        $.ajax({
            async: true,
            type: 'post',
            dataType: 'json',
            data: {
                _token: "{{ csrf_token() }}",
                data1: JSON.stringify(data1),
                data2: JSON.stringify(data2)
            },
            url: '<?= route('simpanmasterbarang') ?>',
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
                    const myForm = document.getElementById('formpendaftaranpasien');
                    myForm.reset();
                }
            }
        });
            }
            });
        
    });

    function addform() {
        var max_fields = 10;
        var wrapper = $(".formobatfarmasi2"); //Fields wrapper
        var x = 1
        jlh = $('#jumlahform').val()
        cek = document.getElementById('jumlahform').value
        if (cek === '') {
            jlh1 = $('#jumlahform').val(1)
        } else {
            cek = parseInt(document.getElementById('jumlahform').value)
            jlh2 = $('#jumlahform').val(cek + 1)
        }
        nomor = parseInt(document.getElementById('jumlahform').value)
        if (x < max_fields) { //max input box allowed
            nama = 'namaobat' + nomor
            aturan = 'aturanpakai' + nomor
            $(wrapper).append(
                '<div class="row text-xs"><div class="form-group col-md-2"><label for="">Nama Barang</label><input type="" class="form-control form-control-sm text-xs" id="' +
                nama +'" name="namabarang" value=""></div><div class="form-group col-md-2"><label for="">Nama Generik</label><input type="" class="form-control form-control-sm text-xs" id="' +
                nama +'" name="namagenerik" value=""></div><div class="form-group col-md-1"><label for="inputPassword4">Jenis Barang</label><select class="form-control" id="jenisbarang" name="jenisbarang"><option>Obat</option><option>Alkes</option><option>ATK</option><option>Lainnya</option></select></div><div class="form-group col-md-1"><label for="inputPassword4">Satuan</label> <select class="form-control" id="satuan" name="satuan"><option>BOX</option><option>PCS</option><option>BOTOL</option><option>Lainnya</option></select></div><div class="form-group col-md-1"><label for="">isi</label><input type="" class="form-control form-control-sm text-xs" id="" name="isi" value="0"></div><div class="form-group col-md-1"><label for="inputPassword4">Sediaan</label> <select class="form-control" id="sediaan" name="sediaan"><option>TABLET</option><option>KAPSUL</option><option>PCS</option><option>BOTOL</option></select></div><div class="form-group col-md-2"><label for="inputPassword4">Aturan Pakai</label><textarea type="" class="form-control form-control-sm" id="" name="keterangan" value=""></textarea></div><i class="bi bi-x-square remove_field form-group col-md-2 text-danger"></i></div>'
            );
            $(wrapper).on("click", ".remove_field", function(e) { //user click on remove
                kode = $(this).attr('kode2')
                e.preventDefault();
                $(this).parent('div').remove();
                x--;
            })
        }
    }

    function go() {
        $('.v_add_master_barang').removeAttr('hidden', true)
        $('.v_data_master').attr('hidden', true)
    }

    function kembali() {
        $('.v_add_master_barang').attr('hidden', true)
        $('.v_data_master').removeAttr('hidden', true)
    }

</script>
@endsection