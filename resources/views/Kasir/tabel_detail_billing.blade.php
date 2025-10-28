 <table class="table table-sm table-bordered">
     <thead>
         <th>Kode Layanan</th>
         <th>Nama</th>
         <th>Harga</th>
         <th>Jumlah</th>
         <th>Subtotal</th>
     </thead>
     <tbody>
         @php
         $gt = 0;
         @endphp
         @foreach ($data_layanan as $d )
         <tr>
             <td>{{ $d->kode_layanan_header}}</td>
             <td>{{ $d->nama_layanan}}</td>
             <td>Rp. {{ number_format($d->tarif, 0, ',', '.') }}</td>
             <td>{{ $d->jumlah_layanan}}</td>
             <td class="fst-italic">Rp. {{ number_format($d->total_tarif, 0, ',', '.') }}</td>
         </tr>
         @php
         $gt = $gt + $d->total_tarif ;
         @endphp
         @endforeach
         <tr>
             <td colspan="4" class="text-end fw-bold">Grand Total</td>
             <td class="fst-italic">
                 Rp. {{ number_format($gt, 0, ',', '.') }}
             </td>
         </tr>
     </tbody>
 </table>
<input hidden type="text" value="{{$gt}}" id="grandtotalbilling">
<input hidden type="text" value="Rp. {{ number_format($gt, 0, ',', '.') }}" id="grandtotalbilling2">