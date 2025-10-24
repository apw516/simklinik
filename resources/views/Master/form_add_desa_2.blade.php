    <div class="mb-3">
        <label for="exampleFormControlInput1" class="form-label">Pilih Kecamatan</label>
        <select class="form-select" aria-label="Default select example" id="kodekecamatan">
            <option>Silahkan Pilih</option>
            @foreach ($kecamatan as $D )
            <option value="{{ $D->code }}">{{ $D->name }}</option>
            @endforeach
        </select>
    </div>
