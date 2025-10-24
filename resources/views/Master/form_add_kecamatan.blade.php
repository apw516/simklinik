<form action="" class="formaddkecamatan">
    <div class="mb-3">
        <label for="exampleFormControlInput1" class="form-label">Pilih Kabupaten</label>
        <select class="form-select" aria-label="Default select example" id="kodekabupaten">
            <option>Silahkan Pilih</option>
            @foreach ($kabupaten as $D )
            <option value="{{ $D->code }}" >{{ $D->name }}</option>
            @endforeach
        </select>
    </div>
</form>
