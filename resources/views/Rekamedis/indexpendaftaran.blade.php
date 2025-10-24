@extends('Template.Main')
@section('container')
<div class="app-content-header">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-6">
                <h3 class="mb-0">Pendaftaran</h3>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-end">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Pendaftaran</li>
                </ol>
            </div>
        </div>
    </div>
</div>
<div class="app-content">
    <div class="container-fluid">
        <div class="v_1">
            <div class="row">
                <div class="col-md-2">
                    <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label">NIK</label>
                        <input type="email" class="form-control" id="nik" aria-describedby="emailHelp"
                            placeholder="Masukan NIK Pasien ...">
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label">Nomor RM</label>
                        <input type="email" class="form-control" id="rm" aria-describedby="emailHelp"
                            placeholder="Masukan Nomor RM Pasien ...">
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label">Nama Pasien</label>
                        <input type="email" class="form-control" id="nama" aria-describedby="emailHelp"
                            placeholder="Masukan Nama Pasien Pasien ...">
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label">Alamat</label>
                        <input type="email" class="form-control" id="alamat" aria-describedby="emailHelp"
                            placeholder="Masukan Alamat Pasien ...">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="mb-3">
                        <button class="btn btn-success" style="margin-top:28px" onclick="caripasien()"> <i
                                class="bi bi-search"></i> Cari Pasien</button>
                        <button class="btn btn-warning" style="margin-top:28px" onclick="formpasienbaru()"> <i
                                class="bi bi-person-add"></i> Pasien Baru</button>
                    </div>
                </div>
            </div>
            <div class="card mt-4">
                <div class="card-header">Data Pasien</div>
                <div class="card-body">

                </div>
            </div>
        </div>
        <div hidden class="v_2">
            <button class="btn btn-danger" onclick="kembali()"><i class="bi bi-backspace"></i> Kembali</button>
            <div class="card mt-3">
                <div class="card-header">Form Pasien Baru</div>
                <div class="card-body">
                    <form class="formpasienbaru">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="mb-2">
                                    <label for="exampleInputEmail1" class="form-label">NIK</label>
                                    <input type="text" class="form-control" id="nik" name="nik"
                                        aria-describedby="emailHelp" placeholder="Masukan nomor identitas pasien ....">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-2">
                                    <label for="exampleInputEmail1" class="form-label">Nama Pasien</label>
                                    <input type="text" class="form-control" id="namapasien" name="namapasien"
                                        aria-describedby="emailHelp" placeholder="Masukan nama pasien ....">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="mb-2">
                                    <label for="exampleInputEmail1" class="form-label">Kota Lahir</label>
                                    <input type="text" class="form-control" id="kotalahir" name="kotalahir"
                                        aria-describedby="emailHelp" placeholder="Masukan Kota lahir ....">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-2">
                                    <label for="exampleInputEmail1" class="form-label">Tanggal Lahir</label>
                                    <input type="date" class="form-control" id="tgllahir" name="tgllahir"
                                        aria-describedby="emailHelp" placeholder="Masukan nomor identitas pasien ....">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-2">
                                    <label for="exampleInputEmail1" class="form-label">Jenis Kelamin</label>
                                    <select class="form-select" aria-label="Default select example" id="jeniskelamin" name="jeniskelamin">
                                        <option value="0">Silahkan Pilih</option>
                                        <option value="male">Pria</option>
                                        <option value="female">Wanita</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-header">Alamat</div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="mb-2">
                                            <label for="exampleInputEmail1" class="form-label">Provinsi</label>
                                            <select class="form-select" aria-label="Default select example"
                                                id="provinsi" name="provinsi" onchange="get_kabupaten()">
                                                <option>Silahkan Pilih</option>
                                                @foreach ($mt_provinsi as $D )
                                                <option value="{{ $D->code }}">{{ $D->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="mb-2">
                                            <label for="exampleInputEmail1" class="form-label">Kabupaten</label>
                                                <div class="v_list_kab">
                                                    <select class="form-select" aria-label="Default select example">
                                                        <option>Silahkan Pilih</option>
                                                    </select>
                                                </div>                                    
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="mb-2">
                                            <label for="exampleInputEmail1" class="form-label">Kecamatan</label>
                                             <div class="v_list_kec">
                                                    <select class="form-select" aria-label="Default select example">
                                                        <option>Silahkan Pilih</option>
                                                    </select>
                                            </div> 
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="mb-2">
                                            <label for="exampleInputEmail1" class="form-label">Desa</label>
                                             <div class="v_list_desa">
                                                    <select class="form-select" aria-label="Default select example">
                                                        <option>Silahkan Pilih</option>
                                                    </select>
                                            </div> 
                                        </div>
                                    </div>
                                </div>
                                <div class="row mt-4">
                                    <div class="col-md-4">
                                        <div class="mb-2">
                                            <label for="exampleInputEmail1" class="form-label">Alamat *(RT / RW / Nama
                                                Jalan)</label>
                                            <textarea rows="4" type="text" class="form-control" id="alamatpasien" name="alamatpasien"
                                                aria-describedby="emailHelp"
                                                placeholder="Masukan alamat pasien ...."></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <button class="btn btn-danger mt-2" onclick="kembali()"><i class="bi bi-backspace"></i>
                            Kembali</button>
                        <button type="button" class="btn btn-primary mt-2" onclick="simpandatapasienbaru()"><i
                                class="bi bi-floppy"></i> Simpan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    function simpandatapasienbaru() {
        Swal.fire({
            title: "Anda yakin ?"
            , text: "Data pasien akan disimpan !"
            , icon: "question"
            , showCancelButton: true
            , confirmButtonColor: "#3085d6"
            , cancelButtonColor: "#d33"
            , confirmButtonText: "Ya Simpan ..."
        }).then((result) => {
            if (result.isConfirmed) {
                savepasienbaru()
            }
        });
    }
    function savepasienbaru()
    {
        var data = $('.formpasienbaru').serializeArray();
        spinner = $('#loader')
        spinner.show();
        $.ajax({
            async: true,
            type: 'post',
            dataType: 'json',
            data: {
                _token: "{{ csrf_token() }}",
                data: JSON.stringify(data),
            },
            url: '<?= route('simpandatapasienbaru') ?>',
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
                }
            }
        });
    }
    function caripasien() {
        nik = $('#nik').val()
        rm = $('#rm').val()
        nama = $('#nama').val()
        alamat = $('#alamat').val()
    }
    function formpasienbaru() {
        $('.v_1').attr('hidden', true)
        $('.v_2').removeAttr('hidden', true)
    }
    function kembali() {
        $('.v_2').attr('hidden', true)
        $('.v_1').removeAttr('hidden', true)
    }
    function get_kabupaten(){
        prov = $('#provinsi').val()
        spinner = $('#loader')
        spinner.show();
        $.ajax({
            type: 'post'
            , data: {
                _token: "{{ csrf_token() }}"
                , prov
            }
            , url: '<?= route('ambil_kabupaten_rekamedis') ?>'
            , success: function(response) {
                spinner.hide();
                $('.v_list_kab').html(response);
            }
        });
    }
    function get_kecamatan(){
        kab = $('#kabupaten').val()
        spinner = $('#loader')
        spinner.show();
        $.ajax({
            type: 'post'
            , data: {
                _token: "{{ csrf_token() }}"
                , kab
            }
            , url: '<?= route('ambil_kecamatan_rekamedis') ?>'
            , success: function(response) {
                spinner.hide();
                $('.v_list_kec').html(response);
            }
        });
    }
    function get_desa(){
        kec = $('#kecamatan').val()
        spinner = $('#loader')
        spinner.show();
        $.ajax({
            type: 'post'
            , data: {
                _token: "{{ csrf_token() }}"
                , kec
            }
            , url: '<?= route('ambil_desa_rekamedis') ?>'
            , success: function(response) {
                spinner.hide();
                $('.v_list_desa').html(response);
            }
        });
    }
</script>
@endsection