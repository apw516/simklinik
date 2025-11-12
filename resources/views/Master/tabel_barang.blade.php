     <table id="tbb" class="table table-sm" id="tabel_master_barang">
         <thead>
             <th>Nama Barang</th>
             <th>Nama Generik</th>
             <th>Distributor</th>
             <th>Jenis Barang</th>
             <th>Satuan</th>
             <th>isi</th>
             <th>Sediaan</th>
             <th>Keterangan</th>
             <th></th>
         </thead>
         <tbody>
             @foreach ($mt_barang as $b )
             <tr>
                 <td>{{ $b->namabarang}}</td>
                 <td>{{ $b->namagenerik}}</td>
                 <td>{{ $b->nama_distributo}}</td>
                 <td>{{ $b->jenisbarang}}</td>
                 <td>{{ $b->satuan}}</td>
                 <td>{{ $b->isi}}</td>
                 <td>{{ $b->sediaan}}</td>
                 <td>{{ $b->keterangan}}</td>
                 <td>
                     <button class="badge text-light bg-success pilihbarang" isi="{{ $b->isi}}" jenis="{{ $b->jenisbarang }}" namabarang="{{ $b->namabarang}}" idbarang="{{ $b->id}}" sediaan="{{ $b->sediaan}}" satuan="{{ $b->satuan}}" namagenerik="{{ $b->namagenerik}}"><i class="bi bi-pencil-square"></i></button>
                 </td>
             </tr>
             @endforeach
         </tbody>
     </table>
     <script>
         $(function() {
             $("#tbb").DataTable({
                 "responsive": true
                 , "lengthChange": false
                 , "autoWidth": false
                 , "pageLength": 12
                 , "searching": true
                 , "ordering": false
             , })
         });
         $(".pilihbarang").on('click', function(event) {
             jenis = $(this).attr('jenis')
             namabarang = $(this).attr('namabarang')
             idbarang = $(this).attr('idbarang')
             sediaan = $(this).attr('sediaan')
             satuan = $(this).attr('satuan')
             isi = $(this).attr('isi')
             namagenerik = $(this).attr('namagenerik')
             var max_fields = 10;
             var wrapper = $(".formobatfarmasi2"); //Fields wrapper
             var x = 1
             if (x < max_fields) { //max input box allowed
                 $(wrapper).append(
                     '<div class="row text-xs"><div class="form-group col-md-2"><label for="">Nama Barang</label><input readonly type="" class="form-control form-control-sm text-xs" id="" name="namabarang" value="'+namabarang+'"></div><div class="form-group col-md-2"><label for="">Nama Generik</label><input readonly type="" class="form-control form-control-sm text-xs" id="" name="namagenerik" value="'+namagenerik+'"><input readonly hidden type="" class="form-control form-control-sm text-xs" id="" name="idbarang" value="'+id+'"></div><div class="form-group col-md-1"><label for="">Jenis Barang</label><input readonly type="" class="form-control form-control-sm text-xs" id="" name="jenis" value="'+jenis+'"></div><div class="form-group col-md-1"><label for="">Satuan</label><input type="" readonly class="form-control form-control-sm text-xs" id="" name="satuan" value="'+satuan+'"></div><div class="form-group col-md-1"><label for="">isi</label><input type="" class="form-control form-control-sm text-xs" id="" name="isi" readonly value="'+isi+'"></div><div class="form-group col-md-1"><label for="">Sediaan</label><input type="" readonly class="form-control form-control-sm text-xs" id="" name="sediaan" value="'+sediaan+'"></div><div class="form-group col-md-1"><label for="">Jumlah PO</label><input type="" class="form-control form-control-sm text-xs" id="" name="jumlah" value="0"></div><i class="bi bi-x-square remove_field form-group col-md-2 text-danger"></i></div>'
                 );
                 $(wrapper).on("click", ".remove_field", function(e) { //user click on remove
                     kode = $(this).attr('kode2')
                     e.preventDefault();
                     $(this).parent('div').remove();
                     x--;
                 })
             }
         });

     </script>
