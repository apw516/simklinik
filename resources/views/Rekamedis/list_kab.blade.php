  <select class="form-select" aria-label="Default select example" id="kabupaten" name="kabupaten" onchange="get_kecamatan()">
      <option>Silahkan Pilih</option>
      @foreach ($kab as $D )
      <option value="{{ $D->code }}">{{ $D->name }}</option>
      @endforeach
  </select>
