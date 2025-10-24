  <select class="form-select" aria-label="Default select example" id="kecamatan" name="kecamatan" onchange="get_desa()">
      <option>Silahkan Pilih</option>
      @foreach ($kec as $D )
      <option value="{{ $D->code }}">{{ $D->name }}</option>
      @endforeach
  </select>
