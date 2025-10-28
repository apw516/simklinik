<button class="btn btn-danger mb-3" onclick="kembaliawal()"><i class="bi bi-backspace-fill"></i> Kembali</button>
<div class="row">
    <div class="col-md-4">
        <div class="card">
            <div class="card-header">Info Pasien</div>
            <div class="card-body">
                <div class="col-md-12">
                    <!-- Profile Image -->
                    <div class="card card-primary card-outline">
                        <div class="card-header"><i class="bi bi-info-circle"></i> Info Pasien</div>
                        <div class="card-body box-profile">
                            <div class="text-center">
                                <img class="profile-user-img img-fluid img-circle" width="20%" src="{{ asset('public/img/user.jpg') }}" alt="User profile picture">
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
                    <div class="card mt-1">
                        <div class="card-header">Riwayat Kunjungan</div>
                        <div class="card-body">
                            <table id="tabelriwayatkunjungandokter" class="table table-sm table-hover" style="font-size:10px">
                                <thead>
                                    <th>Tgl Kunjungan</th>
                                    <th>Unit</th>
                                    <th>Dokter</th>
                                    <th></th>
                                </thead>
                                <tbody>
                                    @foreach ($riwayat as $r )
                                    <tr>
                                        <td>{{ $r->tanggalkunjungan}}</td>
                                        <td>{{ $r->unit}}</td>
                                        <td>{{ $r->namadokter}}</td>
                                        <th>
                                            <button class="badge bg-info"><i class="bi bi-eye"></i></button>
                                        </th>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">Form Hasil Pemeriksaan</div>
            <div class="card-body">
                <form action="" class="formpemeriksaan">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="exampleInputEmail1" class="fst-italic">Tekanan Darah</label>
                                <div class="input-group mb-3">
                                    <input type="text" class="form-control" placeholder="Tekanan darah pasien ..." aria-label="Recipient's username" aria-describedby="basic-addon2" id="tekanandarah" name="tekanandarah" value="{{ $kunjungan[0]->tekanandarah }}">
                                    <span class="input-group-text" id="basic-addon2">(mmHg)</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="exampleInputEmail1" class="fst-italic">Suhu tubuh</label>
                                <div class="input-group mb-3">
                                    <input type="text" class="form-control" placeholder="Suhu tubuh pasien ..." aria-label="Recipient's username" aria-describedby="basic-addon2" id="suhutubuh" name="suhutubuh" value="{{ $kunjungan[0]->suhutubuh }}">
                                    <span class="input-group-text" id="basic-addon2">(°C)</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-5">
                            <div class="mb-3">
                                <label for="exampleFormControlTextarea1" class="form-label fst-italic">Keluhan Utama</label>
                                <textarea class="form-control" id="exampleFormControlTextarea1" name="keluhanpasien" id="keluhanpasien" rows="3" placeholder="Masukan keluhan utama pasien ...">{{ $kunjungan[0]->keluhanpasien }}</textarea>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="exampleFormControlTextarea1" class="form-label fst-italic">Subject</label>
                                <textarea class="form-control" id="exampleFormControlTextarea1" name="subject" id="subject" rows="3" placeholder="Subject ...">{{$kunjungan[0]->subject}}</textarea>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="exampleFormControlTextarea1" class="form-label fst-italic">Object</label>
                                <textarea class="form-control" id="exampleFormControlTextarea1" name="object" id="object" rows="3" placeholder="Object ...">{{$kunjungan[0]->object}}</textarea>
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="exampleFormControlTextarea1" class="form-label fst-italic">Diagnosa Primer</label>
                        <div class="input-group mb-3">
                            <input type="text" class="form-control" name="diagnosaprimer" id="diagnosaprimer" placeholder="Diagnosa primer ..." aria-label="Username" value="{{$kunjungan[0]->diagnosaprimer}}">
                            <span class="input-group-text">ICD 10</span>
                            <input readonly type="text" class="form-control" name="kodediagnosaprimer" id="kodediagnosaprimer" placeholder="ICD 10" aria-label="Server" value="{{$kunjungan[0]->kodediagnosaprimer}}">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="exampleFormControlTextarea1" class="form-label fst-italic">Diagnosa Sekunder</label>
                        <div class="input-group mb-3">
                            <input type="text" class="form-control" name="diagnosasekunder" id="diagnosasekunder" placeholder="Diagnosa sekunder ..." aria-label="Username" value="{{$kunjungan[0]->diagnosasekunder}}">
                            <span class="input-group-text">ICD 10</span>
                            <input readonly type="text" class="form-control" name="kodediagnosasekunder" id="kodediagnosasekunder" placeholder="ICD 10" aria-label="Server" value="{{$kunjungan[0]->kodediagnosasekunder}}">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="exampleFormControlTextarea1" class="form-label fst-italic">Hasil Pemeriksaan</label>
                                <textarea class="form-control" id="hasilpemeriksaan" name="hasilpemeriksaan" rows="3" placeholder="Assesmen ...">{{$kunjungan[0]->hasilpemeriksaan}}</textarea>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="exampleFormControlTextarea1" class="form-label fst-italic">Planning</label>
                                <textarea class="form-control" id="planning" name="planning" rows="3" placeholder="Planning ...">{{$kunjungan[0]->planning}}</textarea>
                            </div>
                        </div>
                    </div>
                </form>
                <div class="card">
                    <div class="card-header">Billing System
                        <button class="btn btn-info float-end riwayatbilling" kodekunjungan="{{ $kode_kunjungan }}" data-bs-toggle="modal" data-bs-target="#modalriwayatbilling"><i class="bi bi-list-columns-reverse"></i> Riwayat Billing</button>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <table id="tabeltarif" class="table table sm text-xs">
                                    <thead>
                                        <th>Nama</th>
                                        <th>Harga</th>
                                        <th></th>
                                    </thead>
                                    <tbody>
                                        @foreach ($mt_tarif as $t)
                                            <tr>
                                                <td>{{ $t->nama}}</td>
                                                <td>Rp. {{ number_format($t->harga, 0, ',', '.') }}</td>
                                                <td>
                                                    <button idtarif="{{$t->id}}" harga1="Rp. {{ number_format($t->harga, 0, ',', '.') }}" harga2="{{$t->harga}}" nama="{{$t->nama }}" class="badge bg-success pilihtarif"><i class="bi bi-check2-circle"></i></button> 
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <div class="col-md-6">
                                <label for="">Tarif yang dipilih ...</label><br>
                                  <form action="" method="post" class="formbilling">
                                    <div class="draftbilling">
                                        <div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <button class="btn btn-success" onclick="simpanassesmen()"><i class="bi bi-floppy"></i> Simpan</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="modalriwayatbilling" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Riwayat Billing</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
            <div class="v_riwayat_billing"></div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
<input hidden type="text" class="form-control" name="kode_kunjungan" id="kode_kunjungan" placeholder="Diagnosa sekunder ..." aria-label="Username" value="{{ $kode_kunjungan }}">
<script>
     $(document).ready(function() {
        $("#diagnosaprimer").autocomplete({
            source: '<?= route('caridiagnosa') ?>', // Laravel route for autocomplete
            minLength: 2,
            select: function(event, ui) {
                $("#diagnosaprimer").val(ui.item.label);
                $("#kodediagnosaprimer").val(ui.item.value);
                return false; // Prevent default action (setting input value to item.value)
            }
        });
        $("#diagnosasekunder").autocomplete({
            source: '<?= route('caridiagnosa') ?>', // Laravel route for autocomplete
            minLength: 2,
            select: function(event, ui) {
                $("#diagnosasekunder").val(ui.item.label);
                $("#kodediagnosasekunder").val(ui.item.value);
                return false; // Prevent default action (setting input value to item.value)
            }
        });
    });
    function kembaliawal() {
        $('.v_utama').removeAttr('hidden', true)
        $('.v_kedua').attr('hidden', true)
    }
    $(function() {
        $("#tabelriwayatkunjungandokter").DataTable({
            "responsive": true
            , "lengthChange": false
            , "autoWidth": false
            , "pageLength": 3
            , "searching": true
            , "ordering": false
        , })
    });
    function simpanassesmen() {
        Swal.fire({
            title: "Anda yakin ?"
            , text: "Hasil pemeriksaan akan disimpan !"
            , icon: "question"
            , showCancelButton: true
            , confirmButtonColor: "#3085d6"
            , cancelButtonColor: "#d33"
            , confirmButtonText: "Ya Simpan ..."
        }).then((result) => {
            if (result.isConfirmed) {
                simpanassesmen2()
            }
        });
    }
    function simpanassesmen2() {        
        var data = $('.formpemeriksaan').serializeArray();
        var data2 = $('.formbilling').serializeArray();
        var kode_kunjungan = $('#kode_kunjungan').val()
        spinner = $('#loader')
        spinner.show();
        $.ajax({
            async: true
            , type: 'post'
            , dataType: 'json'
            , data: {
                _token: "{{ csrf_token() }}"
                , data: JSON.stringify(data)
                , data2: JSON.stringify(data2)
                , kode_kunjungan
            , }
            , url: '<?= route('simpanpemeriksaandokter') ?>'
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
                    const myForm = document.getElementById('formpendaftaranpasien');
                    myForm.reset();
                }
            }
        });
    }
   $(function() {
        $("#tabeltarif").DataTable({
            "responsive": true
            , "lengthChange": false
            , "autoWidth": false
            , "pageLength": 5
            , "searching": true
            , "ordering": false
        , })
    });
    $(".pilihtarif").on('click', function(event) {
        idtarif = $(this).attr('idtarif')
        nama = $(this).attr('nama')
        harga1 = $(this).attr('harga1')
        harga2 = $(this).attr('harga2')
        var wrapper = $(".draftbilling");
        $(wrapper).append(
            '<div class="row text-xs"><div class="form-group col-md-6"><label for="">Nama Tarif</label><input readonly type="" class="form-control form-control-sm text-xs edit_field" id="namatarif" name="namatarif" value="' +
            nama +
            '"><input   hidden readonly type="" class="form-control form-control-sm" id="idtarif" name="idtarif" value="' +
            idtarif +
            '"><input   hidden readonly type="" class="form-control form-control-sm" id="harga2" name="harga2" value="' +
            harga2 +
            '"></div><div class="form-group col-md-4"><label for="">Harga</label><input readonly type="" class="form-control form-control-sm text-xs edit_field" id="harga" name="harga" value="' +
            harga1 +
            '"></div><i class="bi bi-x-square remove_field form-group col-md-1 text-danger" kode2=""></i></div>'
        );
        Swal.fire({
            title: "Tarif dipilih " + nama,
            text: "ok!",
            icon: "success"
        });
        $(wrapper).on("click", ".remove_field", function(e) { //user click on remove
            e.preventDefault();
            $(this).parent('div').remove();
            x--;
        })
    });
    $(".riwayatbilling").on('click', function(event) {
        kode_kunjungan = $('#kode_kunjungan').val()
        spinner = $('#loader')
        spinner.show();
        $.ajax({
            type: 'post'
            , data: {
                _token: "{{ csrf_token() }}"
                , kode_kunjungan
            }
            , url: '<?= route('ambilriwayatbilling') ?>'
            , success: function(response) {
                $('.v_riwayat_billing').html(response);
            }
        });
    });

</script>
