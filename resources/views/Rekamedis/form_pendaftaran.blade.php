<button class="btn btn-danger" onclick="kembaliawal()"><i class="bi bi-backspace-fill"></i> Kembali</button>
<div class="row mt-4">
    <div class="col-md-3">
        <div class="col-md-12">
            <!-- Profile Image -->
            <div class="card card-primary card-outline">
                <div class="card-header"><i class="bi bi-info-circle"></i> Info Pasien</div>
                <div class="card-body box-profile">
                    <div class="text-center">
                        <img class="profile-user-img img-fluid img-circle" width="40%" src="{{ asset('public/img/user.jpg') }}" alt="User profile picture">
                    </div>
                    <p class="text-bold profile-username text-center text-md">{{ $mt_pasien[0]->namapasien }} |
                        {{ $mt_pasien[0]->no_rm }}</p>
                    <p class="text-bold text-center text-xs"></p>
                    <p class="text-bold text-center text-xs">,
                        {{ \Carbon\Carbon::parse($mt_pasien[0]->tgllahir)->format('Y-m-d') }}
                        (Usia {{ \Carbon\Carbon::parse($mt_pasien[0]->tgllahir)->age }})</p>
                    <p class="text-bold text-center text-xs">Alamat : {{ $mt_pasien[0]->alamatpasien }} </p>
                    <p class="text-bold text-center text-xs">Jenis Kelamin :
                        @if ($mt_pasien[0]->jeniskelamin == 'male')
                        Laki - Laki
                        @elseif ($mt_pasien[0]->jeniskelamin == 'female' || $mt_pasien[0]->jeniskelamin == 'l')
                        Perempuan
                        @else
                        {{ $mt_pasien[0]->jeniskelamin }}
                        @endif
                    </p>
                </div>
                <!-- /.card-body -->
            </div>

        </div>
    </div>
    <div class="col-md-4">
        <div class="card">
            <div class="card-header bg-primary text-light">Riwayat Kunjungan</div>
            <div class="card-body">
                <div class="v_tabel_riwayat_kunjungan">

                </div>
            </div>
        </div>
    </div>
    <div class="col-md-5" >
        <div class="card">
            <div class="card-header bg-primary text-light">Form Pendaftaran</div>
            <div class="card-body">
                <form action="" class="formpendaftaranpasien">
                    <form>
                        <div class="mb-3">
                            <label for="exampleInputEmail1" class="form-label">Unit Tujuan</label>
                            <input type="text" class="form-control form-control-sm" id="unit" name="unit" aria-describedby="emailHelp" placeholder="Silahkan pilih unit tujuan ...">
                            <input hidden type="text" class="form-control form-control-sm" id="kodeunit" name="kodeunit" aria-describedby="emailHelp" placeholder="Silahkan pilih unit tujuan ...">
                            <input hidden type="text" class="form-control form-control-sm" id="no_rm" name="no_rm" aria-describedby="emailHelp" placeholder="Silahkan pilih unit tujuan ..." value="{{ $mt_pasien[0]->no_rm}}">
                        </div>
                        <div class="mb-3">
                            <label for="exampleInputEmail1" class="form-label">Dokter Pemeriksa</label>
                            <input type="text" class="form-control form-control-sm" id="namadokter" name="namadokter" aria-describedby="emailHelp" placeholder="Silahkan pilih dokter pemeriksa ...">
                            <input hidden type="text" class="form-control form-control-sm" id="kodedokter" name="kodedokter" aria-describedby="emailHelp" placeholder="Silahkan pilih dokter pemeriksa ...">
                        </div>
                        <div class="mb-3">
                            <label for="exampleInputEmail1" class="form-label">Tanggal Kunjungan</label>
                            <input type="date" class="form-control form-control-sm" id="tanggalkunjungan" name="tanggalkunjungan" aria-describedby="emailHelp" placeholder="Silahkan pilih unit tujuan ..." value="{{ $date }}">
                        </div>
                        <div class="card">
                            <div class="card-header">Tanda tanda Vital</div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <label for="exampleInputEmail1" class="form-label">Tekanan Darah</label>
                                        <input type="text" class="form-control form-control-sm" id="tekanandarah" name="tekanandarah" aria-describedby="emailHelp" placeholder="Silahkan isi tekanan darah pasien ...">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="exampleInputEmail1" class="form-label">Suhu Tubuh</label>
                                        <input type="text" class="form-control form-control-sm" id="suhutubuh" name="suhutubuh" aria-describedby="emailHelp" placeholder="Silahkan suhu tubuh pasien ...">
                                    </div>
                                    <div class="col-md-12">
                                        <label for="exampleInputEmail1" class="form-label">Keluhan Pasien</label>
                                        <textarea rows="5" type="text" class="form-control form-control-sm" id="keluhanpasien" name="keluhanpasien" aria-describedby="emailHelp" placeholder="Masukan keluhan pasien ..."></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <button type="button" class="btn btn-primary mt-2" onclick="simpanpendaftaran()">Simpan</button>
                    </form>
                </form>
            </div>
        </div>
    </div>
</div>
<script>
     $(document).ready(function() {
        ambilriwayatkunjungan()
        $("#unit").autocomplete({
            source: '<?= route('cariunit') ?>', // Laravel route for autocomplete
            minLength: 2,
            select: function(event, ui) {
                $("#unit").val(ui.item.label);
                $("#kodeunit").val(ui.item.value);
                return false; // Prevent default action (setting input value to item.value)
            }
        });
        $("#namadokter").autocomplete({
            source: '<?= route('caridokter') ?>', // Laravel route for autocomplete
            minLength: 2,
            select: function(event, ui) {
                $("#namadokter").val(ui.item.label);
                $("#kodedokter").val(ui.item.value);
                return false; // Prevent default action (setting input value to item.value)
            }
        });
    });
    function kembaliawal() {
        $('.v_utama').removeAttr('hidden', true)
        $('.v_kedua').attr('hidden', true)
    }
    function simpanpendaftaran() {
            Swal.fire({
                title: "Anda yakin ?"
                , text: "Data Pendaftaran akan disimpan !"
                , icon: "question"
                , showCancelButton: true
                , confirmButtonColor: "#3085d6"
                , cancelButtonColor: "#d33"
                , confirmButtonText: "Ya Simpan ..."
            }).then((result) => {
                if (result.isConfirmed) {
                    simpanpendaftaran2()
                }
            });
        }
    function simpanpendaftaran2()
    {
        var data = $('.formpendaftaranpasien').serializeArray();
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
            url: '<?= route('simpanpendaftaranpasien') ?>',
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
    function ambilriwayatkunjungan()
    {
        rm = $('#no_rm').val()
        spinner = $('#loader')
        spinner.show();
        $.ajax({
            type: 'post'
            , data: {
                _token: "{{ csrf_token() }}"
                , rm
            }
            , url: '<?= route('ambilriwayatkunjungan') ?>'
            , success: function(response) {
                $('.v_tabel_riwayat_kunjungan').html(response);
            }
        });
    }
</script>
