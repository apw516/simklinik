 <div class="mb-3">
     <label for="exampleFormControlInput1" class="form-label">Nama Unit</label>
     <input type="text" class="form-control" id="namaunit" placeholder="Masukan nama unit ..." value="{{ $dataunit[0]->nama }}">
 </div>
 <div class="mb-3">
     <label for="exampleFormControlInput1" class="form-label">Jenis Unit</label>
     <select class="form-select" id="jenisunit" aria-label="Default select example">
         <option selected>Silahkan Pilih</option>
         <option value="RJ" @if($dataunit[0]->jenis == 'RJ') selected @endif>Rawat Jalan</option>
         <option value="RI" @if($dataunit[0]->jenis == 'RI') selected @endif>Rawat Inap</option>
         <option value="AD" @if($dataunit[0]->jenis == 'AD') selected @endif>Administrasi</option>
     </select>
 </div>
 <div class="mb-3">
     <label for="exampleFormControlInput1" class="form-label">Status</label>
     <select class="form-select" id="jenisunit" aria-label="Default select example">
         <option selected>Silahkan Pilih</option>
         <option value="1" @if($dataunit[0]->status == '1') selected @endif>Aktif</option>
         <option value="0" @if($dataunit[0]->status == '0') selected @endif>Tidak Aktif</option>
     </select>
 </div>
