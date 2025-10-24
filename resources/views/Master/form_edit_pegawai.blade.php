   <form action="" class="formeditpegawai">
       <div class="mb-3">
           <label for="exampleFormControlInput1" class="form-label">NIK Pegawai</label>
           <input type="text" class="form-control" name="nikpegawai" id="nikpegawai" placeholder="Masukan nik pegawai ..." value="{{ $datapegawai[0]->NIK}}">
       </div>
       <div class="mb-3">
           <label for="exampleFormControlInput1" class="form-label">Nama Lengkap</label>
           <input type="text" class="form-control" name="namalengkap" id="namalengkap" placeholder="Masukan nama lengkap beserta gelar ..." value="{{ $datapegawai[0]->nama}}">
       </div>
       <div class="mb-3">
           <label for="exampleFormControlInput1" class="form-label">Nomor Kontak</label>
           <input type="text" class="form-control" name="nomorkontak" id="nomorkontak" placeholder="Masukan nomor kontak ..." value="{{ $datapegawai[0]->kontak}}">
       </div>
       <div class="mb-3">
           <label for="exampleFormControlInput1" class="form-label">Jabatan</label>
           <select class="form-select" name="jabatan" id="jabatan" aria-label="Default select example">
               <option>Silahkan Pilih</option>
               <option @if($datapegawai[0]->jabatan == 'Admin') selected @endif value="Admin">Admin</option>
               <option @if($datapegawai[0]->jabatan == 'Perawat') selected @endif value="Perawat">Perawat</option>
               <option @if($datapegawai[0]->jabatan == 'Bidan') selected @endif value="Bidan">Bidan</option>
               <option @if($datapegawai[0]->jabatan == 'Apoteker') selected @endif value="Apoteker">Apoteker</option>
           </select>
       </div>
       <div class="mb-3">
           <label for="exampleFormControlInput1" class="form-label">Status</label>
           <select class="form-select" name="status" id="status" aria-label="Default select example">
               <option>Silahkan Pilih</option>
               <option @if($datapegawai[0]->status == '1') selected @endif value="1">Aktif</option>
               <option @if($datapegawai[0]->status == '0') selected @endif value="0">Tidak Aktif</option>
           </select>
       </div>
   </form>
