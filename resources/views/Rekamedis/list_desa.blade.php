  <select class="form-select" aria-label="Default select example" id="desa" name="desa">
      <option>Silahkan Pilih</option>
      @foreach ($desa as $D )
      <option value="{{ $D->code }}">{{ $D->name }}</option>
      @endforeach
  </select>
