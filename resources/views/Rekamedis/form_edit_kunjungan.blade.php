@if($ts_kunjungan[0]->status_pemeriksaan == 1)
<div class="alert alert-danger" role="alert">
    Pasien sudah diperiksa dokter
</div>
@endif
<div class="card">
    <div class="card-header">Form Edit Kunjungan</div>
    <div class="card-body">
        <div class="form-group">
            <label for="exampleFormControlSelect1">Status Kunjungan</label>
            <select class="form-control" id="statuskunjungan" name="statuskunjungan">
                <option @if($ts_kunjungan[0]->statuskunjungan == 1) selected @endif>Aktif</option>
                <option @if($ts_kunjungan[0]->statuskunjungan == 2) selected @endif>Selesai</option>
                <option @if($ts_kunjungan[0]->statuskunjungan == 3) selected @endif>Batal</option>
            </select>
        </div>
        <div class="form-group">
            <label for="exampleFormControlSelect1">Dokter</label>
            <select class="form-control" id="kodedokter" name="kodedokter">
                @foreach ($dokter as $d )
                    <option @if($ts_kunjungan[0]->kodedokter == $d->id) selected @endif>{{ $d->nama}}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="card-footer">
        <button class="btn btn-success float-end simpaneditkunjungan"><i class="bi bi-floppy"></i>  Simpan Edit Kunjungan</button>
    </div>
</div>
