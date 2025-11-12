@extends('Template.Main')
@section('container')
<div class="app-content-header">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-6">
                <h3 class="mb-0">Data Purchase Order</h3>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-end">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Data Purchase Order</li>
                </ol>
            </div>
        </div>
    </div>
</div>
<div class="app-content">
    <div class="container-fluid">
        <div class="v_purchase_order">
            <button class="btn btn-success mb-3" onclick="buatpo()"><i class="bi bi-folder-plus mr-1 ml-1"></i> Buat
                Purchase Order</button>
            <div class="card">
                <div class="card-header">Riwayat Purchase Order</div>
                <div class="card-body">
                    <table id="tbpo" class="table table-sm table-bordered">
                        <thead>
                            <th>Kode PO</th>
                            <th>Tanggl PO</th>
                            <th>Tanggl Entry</th>
                            <th>Distributor</th>
                            <th>Alamat Distributor</th>
                            <th>Kontak Distributor</th>
                            <th>Jenis PO</th>
                            <th>Status</th>
                            <th></th>
                        </thead>
                        <tbody>
                            @foreach($datapo as $dd)
                            <tr>
                                <td>{{ $dd->kode_PO}}</td>
                                <td>{{ $dd->tanggal_po}}</td>
                                <td>{{ $dd->tgl_entry}}</td>
                                <td>{{ $dd->namadistributor}}</td>
                                <td>{{ $dd->alamat}}</td>
                                <td>{{ $dd->notelp}}</td>
                                <td>{{ $dd->jenis}}</td>
                                <td>@if($dd->status == 0) Belum diterima @elseif($dd->status == 1) Sudah diterima @endif </td>
                                <td>
                                    <button idpo="{{ $dd->id }}" class="btn btn-success terimapo" data-placement="top" title="Terima po ..." @if($dd->status == 1) disabled @endif><i class="bi bi-bookmarks"></i></button>
                                    <button idpo="{{ $dd->id }}" class="btn btn-info detailpo" data-placement="top" title="detail po ..."><i class="bi bi-eye"></i></button>
                                </td>
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