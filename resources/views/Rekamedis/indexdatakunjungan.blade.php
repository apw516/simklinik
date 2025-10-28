@extends('Template.Main')
@section('container')
<div class="app-content-header">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-6">
                <h3 class="mb-0">Data Kunjungan</h3>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-end">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Data Kunjungan</li>
                </ol>
            </div>
        </div>
    </div>
</div>
<div class="app-content">
    <div class="container-fluid">
        <div class="v_utama">
            <div class="v_1">
                <div class="row">
                    <div class="col-md-2">
                        <div class="mb-3">
                            <label for="exampleInputEmail1" class="form-label">Tanggal awal</label>
                            <input type="date" class="form-control" value="{{ $now }}" id="tanggalawal" aria-describedby="emailHelp" placeholder="Masukan NIK Pasien ...">
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="mb-3">
                            <label for="exampleInputEmail1" class="form-label">Tanggal Akhir</label>
                            <input type="date" class="form-control" value="{{ $now }}" id="tanggalakhir" aria-describedby="emailHelp" placeholder="Masukan Nomor RM Pasien ...">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="mb-3">
                            <button class="btn btn-success" style="margin-top:28px" onclick="caripasien()"> <i class="bi bi-search"></i> Cari Pasien</button>
                        </div>
                    </div>
                </div>
                <div class="card mt-4">
                    <div class="card-header">Data Kunjungan</div>
                    <div class="card-body">
                        <div class="v_tabel_pasien"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
     $(document).ready(function() {
            caripasien()
        })
    function caripasien() {
        tglawal = $('#tanggalawal').val()
        tglakhir = $('#tanggalakhir').val()
        spinner = $('#loader')
        spinner.show();
        $.ajax({
            type: 'post'
            , data: {
                _token: "{{ csrf_token() }}"
                , tglawal
                , tglakhir
            }
            , url: '<?= route('carikunjunganrekamedis') ?>'
            , success: function(response) {
                spinner.hide();
                $('.v_tabel_pasien').html(response);
            }
        });
    }

</script>
@endsection
