@extends('Template.Main')
@section('container')
<div class="app-content-header">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-6">
                <h3 class="mb-0">Data Stok Obat</h3>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-end">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Data Stok Obat</li>
                </ol>
            </div>
        </div>
    </div>
</div>
<div class="app-content">
    <div class="container-fluid">
        <div class="v_purchase_order">
            {{-- <button class="btn btn-success mb-3" onclick="buatpo()"><i class="bi bi-folder-plus mr-1 ml-1"></i> Buat
                Purchase Order</button> --}}
            <div class="card">
                <div class="card-header">Stok Obat</div>
                <div class="card-body">
                    <table id="tbpo" class="table table-sm table-bordered" style="font-size: 12px">
                        <thead>
                            <th>Kode PO</th>
                            <th>Tanggal Sediaan</th>
                            <th>Kode Bacth</th>
                            <th>Nama Obat</th>
                            <th>ED</th>
                            <th>Sediaan</th>
                            <th>Satuan</th>
                            <th>Stok Awal </th>
                            <th>Stok current</th>
                            <th>Harga Satuan Besar</th>
                            <th>Harga Satuan Kecil</th>
                            <th>Last update</th>
                        </thead>
                        <tbody>
                            @foreach($datastok as $dd)
                            <tr>
                                <td>{{ $dd->kode_po}}</td>
                                <td>{{ \Carbon\Carbon::parse($dd->tgl_sediaan)->format('d-M-Y') }}</td>
                                <td>{{ $dd->kodebatch}}</td>
                                <td>{{ $dd->nama_barang}} </td>
                                <td>{{ \Carbon\Carbon::parse($dd->ed)->format('d-M-Y') }}</td>
                                <td>{{ $dd->sediaan}}</td>
                                <td>{{ $dd->satuan}}</td>
                                <td>{{ $dd->stok_satuan_besar}} {{ $dd->satuan}} / {{ $dd->stok_satuan_kecil }} {{ $dd->sediaan }}</td>
                                <td>{{ $dd->stok_current}} {{ $dd->sediaan }}</td>
                                <td>Rp. {{ number_format($dd->harga_beli_satuan_besar, 0, ',', '.') }}</td>
                                <td>Rp. {{ number_format($dd->harga_beli_satuan_kecil, 0, ',', '.') }}</td>
                                <td>{{ \Carbon\Carbon::parse($dd->last_update)->format('d, M Y H:i') }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div hidden class="buat_po">
            <button class="btn btn-danger mb-3" onclick="kembali()"><i class="bi bi-backspace mr-1 ml-1"></i>
                Kembali</button>
            <div class="v_form_po">

            </div>
        </div>
    </div>
</div>
<script>
    $(function() {
             $("#tbpo").DataTable({
                 "responsive": true
                 , "lengthChange": false
                 , "autoWidth": false
                 , "pageLength": 12
                 , "searching": true
                 , "ordering": false
             , })
         });
    function buatpo() {
        $('.v_purchase_order').attr('hidden', true)
        $('.buat_po').removeAttr('hidden', true)
        id = $(this).attr('idpegawai')
        spinner = $('#loader')
        spinner.show();
        $.ajax({
            type: 'post'
            , data: {
                _token: "{{ csrf_token() }}"
            }
            , url: '<?= route('ambilformpurchaseorder') ?>'
            , success: function(response) {
                spinner.hide();
                $('.v_form_po').html(response);
            }
        });
    }
    function kembali() {
        $('.v_purchase_order').removeAttr('hidden', true)
        $('.buat_po').attr('hidden', true)
    }
    $(".terimapo").on('click', function(event) {
            id = $(this).attr('idpo')
            spinner = $('#loader')
            spinner.show();
            $.ajax({
                type: 'post'
                , data: {
                    _token: "{{ csrf_token() }}"
                    , id
                }
                , url: '<?= route('ambil_form_terima_po') ?>'
                , success: function(response) {
                    spinner.hide();
                    $('.v_purchase_order').attr('hidden', true)
                    $('.buat_po').removeAttr('hidden', true)
                    $('.v_form_po').html(response);
                }
            });
        });
</script>
@endsection