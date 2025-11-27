 <table class="table table-sm table-bordered">
     <thead>
         <th>Kode Layanan</th>
         <th>Nama</th>
         <th>Harga</th>
         <th>Jumlah</th>
         <th>Subtotal</th>
         <th>Action</th>
     </thead>
     <tbody>
         @php
             $gt = 0;
         @endphp
         @foreach ($data_layanan as $d)
             <tr>
                 <td>{{ $d->kode_layanan_header }}
                 </td>
                 <td>{{ $d->nama_layanan }}</td>
                 <td>Rp. {{ number_format($d->tarif, 0, ',', '.') }}</td>
                 <td>{{ $d->jumlah_layanan }}</td>
                 <td class="fst-italic">Rp. {{ number_format($d->total_tarif, 0, ',', '.') }}</td>
                 <td>
                     <button class="btn btn-danger returdetail" iddetail="{{ $d->iddetail }}"><i
                             class="bi bi-recycle"></i></button>
                 </td>
             </tr>
             @php
                 $gt = $gt + $d->total_tarif;
             @endphp
         @endforeach
         <tr>
             <td colspan="4" class="text-end fw-bold">Grand Total</td>
             <td class="fst-italic" colspan="2">
                 Rp. {{ number_format($gt, 0, ',', '.') }}
             </td>
         </tr>
     </tbody>
 </table>
 <input hidden type="text" value="{{ $gt }}" id="grandtotalbilling">
 <input hidden type="text" value="Rp. {{ number_format($gt, 0, ',', '.') }}" id="grandtotalbilling2">
 <input hidden type="text" value="{{ $kode_kunjungan }}" id="kodekunjungan">
 <script>
     $(document).ready(function() {
         cektagihan()
     })

     function cektagihan() {
         total = $('#grandtotalbilling').val()
         if (total == 0) {
             $('.btnterima').attr('hidden', true)
             $('.btnretur').attr('hidden', true)
         }
     }
     $(".returdetail").on('click', function(event) {
         iddetail = $(this).attr('iddetail')
         Swal.fire({
             title: "Anda yakin ?",
             text: "Layanan akan dibatalkan !",
             icon: "question",
             showCancelButton: true,
             confirmButtonColor: "#3085d6",
             cancelButtonColor: "#d33",
             confirmButtonText: "Ya batal ..."
         }).then((result) => {
             if (result.isConfirmed) {
                 returan(iddetail)
             }
         });
     });

     function returan(id) {
         spinner = $('#loader')
         spinner.show();
         kodekunjungan = $('#kodekunjungan').val()
         $.ajax({
             type: 'post',
             data: {
                 _token: "{{ csrf_token() }}",
                 id
             },
             url: '<?= route('returlayanandetail') ?>',
             error: function(response) {
                 spinner.hide();
                 alert('error')
             },
             success: function(response) {
                 spinner.hide();
                 reload(kodekunjungan)
             }
         });
     }

     function reload(kodekunjungan) {
         spinner = $('#loader')
         spinner.show();
         $.ajax({
             type: 'post',
             data: {
                 _token: "{{ csrf_token() }}",
                 kodekunjungan
             },
             url: '<?= route('ambildatabilling') ?>',
             success: function(response) {
                 spinner.hide();
                 $('.v_utama1').attr('hidden', true)
                 $('.v_kedua2').removeAttr('hidden', true)
                 $('.v_kedua2').html(response);
             }
         });
     }
 </script>
