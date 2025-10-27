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
        <div class="v_utama">
        <div class="v_1">
            <button class="btn btn-info mb-3" data-bs-toggle="modal" data-bs-target="#modalriwayatpendaftaran" onclick="riwayatpendaftaran()"><i class="bi bi-list-task"></i> Riwayat Pendaftaran</button>
            <div class="row">
                <div class="col-md-2">
                    <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label">NIK</label>
                        <input type="text" class="form-control" id="nik" aria-describedby="emailHelp"
                            placeholder="Masukan NIK Pasien ...">
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label">Nomor RM</label>
                        <input type="text" class="form-control" id="rm" aria-describedby="emailHelp"
                            placeholder="Masukan Nomor RM Pasien ...">
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label">Nama Pasien</label>
                        <input type="text" class="form-control" id="nama" aria-describedby="emailHelp"
                            placeholder="Masukan Nama Pasien Pasien ...">
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label">Alamat</label>
                        <input type="text" class="form-control" id="alamat" aria-describedby="emailHelp"
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
                    <div class="v_tabel_pasien"></div>
                </div>
            </div>
        </div>
        <div hidden class="v_2">
            <button class="btn btn-danger" onclick="kembali()"><i class="bi bi-backspace"></i> Kembali</button>
            <div class="card mt-3">
                <div class="card-header">Form Pasien Baru</div>
                <div class="card-body">
                    <form class="formpasienbaru" id="formpasienbaru">
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
                                            <input type="text" class="form-control" id="provinsi" name="provinsi"
                                                aria-describedby="emailHelp" placeholder="Pilih provinsi ....">
                                            <input hidden type="text" class="form-control" id="kodeprovinsi" name="kodeprovinsi"
                                                aria-describedby="emailHelp" placeholder="Masukan nomor identitas pasien ....">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="mb-2">
                                            <label for="exampleInputEmail1" class="form-label">Kabupaten</label>
                                            <input type="text" class="form-control" id="kabupaten" name="kabupaten"
                                                aria-describedby="emailHelp" placeholder="Pilih kabupaten ....">
                                            <input hidden type="text" class="form-control" id="kodekabupaten" name="kodekabupaten"
                                                aria-describedby="emailHelp" placeholder="Masukan nomor identitas pasien ....">                         
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="mb-2">
                                            <label for="exampleInputEmail1" class="form-label">Kecamatan</label>
                                            <input type="text" class="form-control" id="kecamatan" name="kecamatan"
                                                aria-describedby="emailHelp" placeholder="Pilih kecamatan ....">
                                            <input hidden type="text" class="form-control" id="kodekecamatan" name="kodekecamatan"
                                                aria-describedby="emailHelp" placeholder="Masukan nomor identitas pasien ....">      
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="mb-2">
                                            <label for="exampleInputEmail1" class="form-label">Desa</label>
                                             <input type="text" class="form-control" id="desa" name="desa"
                                                aria-describedby="emailHelp" placeholder="Pilih desa ....">
                                            <input hidden type="text" class="form-control" id="kodedesa" name="kodedesa"
                                                aria-describedby="emailHelp" placeholder="Masukan nomor identitas pasien ...."> 
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
        <div hidden class="v_kedua">
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="modalriwayatpendaftaran" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Riwayat Pendaftaran</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="v_tabel_modal"></div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
<script>   
    $('#rm').on('keypress', function(event) {
        caripasien()
    });
    $('#nama').on('keypress', function(event) {
        caripasien()
    });
    $('#nik').on('keypress', function(event) {
        caripasien()
    });
    $('#alamat').on('keypress', function(event) {
        caripasien()
    });
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
                    const myForm = document.getElementById('formpasienbaru');
                    myForm.reset();
                }
            }
        });
    }
    function caripasien() {
        nik = $('#nik').val()
        rm = $('#rm').val()
        nama = $('#nama').val()
        alamat = $('#alamat').val()
            spinner = $('#loader')
            spinner.show();
            $.ajax({
                type: 'post'
                , data: {
                    _token: "{{ csrf_token() }}"
                    , rm,nama,alamat,nik
                }
                , url: '<?= route('caripasien') ?>'
                , success: function(response) {
                    spinner.hide();
                    $('.v_tabel_pasien').html(response);
                }
            });
    }
    function formpasienbaru() {
        $('.v_1').attr('hidden', true)
        $('.v_2').removeAttr('hidden', true)
    }
    function kembali() {
        $('.v_2').attr('hidden', true)
        $('.v_1').removeAttr('hidden', true)
    }
    function riwayatpendaftaran(){
         spinner = $('#loader')
            spinner.show();
            $.ajax({
                type: 'post'
                , data: {
                    _token: "{{ csrf_token() }}"
                }
                , url: '<?= route('riwayatpendaftaran') ?>'
                , success: function(response) {
                    spinner.hide();
                    $('.v_tabel_modal').html(response);
                }
            });
    }
    $(document).ready(function() {
         caripasien()
        $("#provinsi").autocomplete({
            source: '<?= route('cariprovinsi') ?>', // Laravel route for autocomplete
            minLength: 2,
            select: function(event, ui) {
                $("#provinsi").val(ui.item.label);
                $("#kodeprovinsi").val(ui.item.value);
                return false; // Prevent default action (setting input value to item.value)
            }
        });
        $("#kabupaten").autocomplete({
            source: function(request, response) {
                $.ajax({
                    url: "<?= route('carikabupaten') ?>", // Your Laravel route
                    dataType: "json",
                    data: {
                        term: request.term,
                        kodeprovinsi: $("#kodeprovinsi").val(), // Value from another input field
                    },
                    success: function(data) {
                        response(data); // Pass the received data to the autocomplete
                    }
                });
            },
            minLength: 2,
            select: function(event, ui) {
                $("#kabupaten").val(ui.item.label);
                $("#kodekabupaten").val(ui.item.value);
                return false; // Prevent default action (setting input value to item.value)
            }
        });
        $("#kecamatan").autocomplete({
            source: function(request, response) {
                $.ajax({
                    url: "<?= route('carikecamatan') ?>", // Your Laravel route
                    dataType: "json",
                    data: {
                        term: request.term,
                        kodekabupaten: $("#kodekabupaten").val(), // Value from another input field
                    },
                    success: function(data) {
                        response(data); // Pass the received data to the autocomplete
                    }
                });
            },
            minLength: 2,
            select: function(event, ui) {
                $("#kecamatan").val(ui.item.label);
                $("#kodekecamatan").val(ui.item.value);
                return false; // Prevent default action (setting input value to item.value)
            }
        });
        $("#desa").autocomplete({
            source: function(request, response) {
                $.ajax({
                    url: "<?= route('caridesa') ?>", // Your Laravel route
                    dataType: "json",
                    data: {
                        term: request.term,
                        kodekecamatan: $("#kodekecamatan").val(), // Value from another input field
                    },
                    success: function(data) {
                        response(data); // Pass the received data to the autocomplete
                    }
                });
            },
            minLength: 2,
            select: function(event, ui) {
                $("#desa").val(ui.item.label);
                $("#kodedesa").val(ui.item.value);
                return false; // Prevent default action (setting input value to item.value)
            }
        });
    });
</script>
@endsection