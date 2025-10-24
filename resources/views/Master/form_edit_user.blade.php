<form action="" class="formedituser">
    <div class="mb-2">
        <label for="exampleFormControlInput1" class="form-label">NIK Pegawai</label>
        <input type="text" class="form-control" id="exampleFormControlInput1" placeholder="name@example.com" value="{{ $datauser[0]->nik_pegawai}}">
        <input hidden type="text" class="form-control" id="exampleFormControlInput1" placeholder="name@example.com" value="{{ $datauser[0]->id}}">
    </div>
    <div class="mb-2">
        <label for="exampleFormControlInput1" class="form-label">Nama</label>
        <input type="text" class="form-control" id="exampleFormControlInput1" placeholder="name@example.com" value="{{ $datauser[0]->nama}}">
    </div>
    <div class="mb-2">
        <label for="exampleFormControlInput1" class="form-label">Username</label>
        <input type="text" class="form-control" id="exampleFormControlInput1" placeholder="name@example.com" value="{{ $datauser[0]->username}}">
    </div>
    <div class="mb-3">
        <label for="exampleFormControlInput1" class="form-label">Hak Akses</label>
        <select class="form-select" aria-label="Default select example">
            <option>Silahkan Pilih</option>
            <option value="1" @if($datauser[0]->hak_akses == 1) selected @endif>Super Admin</option>
            <option value="2" @if($datauser[0]->hak_akses == 2) selected @endif>Admin</option>
            <option value="3" @if($datauser[0]->hak_akses == 3) selected @endif>Guest</option>
        </select>
    </div>
    <div class="mb-3">
        <label for="exampleFormControlInput1" class="form-label">Unit</label>
        <select class="form-select" aria-label="Default select example">
            <option >Silahkan Pilih</option>
            @foreach($dataunit as $ad)
            <option value="{{ $ad->kode_unit }}" @if($datauser[0]->unit == $ad->kode_unit) selected @endif>{{ $ad->nama }}</option>
            @endforeach
        </select>
    </div>
    <div class="mb-3">
        <label for="exampleFormControlInput1" class="form-label">Status</label>
        <select class="form-select" aria-label="Default select example">
            <option selected>Silahkan Pilih</option>
            <option value="1" @if($datauser[0]->is_activated == 1) selected @endif>Aktif</option>
            <option value="0" @if($datauser[0]->is_activated == 0) selected @endif>Tidak Aktif</option>
        </select>
    </div>
</form>
