@extends('Template.Main')
@section('container')
<div class="app-content-header">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-6">
                <h3 class="mb-0">Data Order Obat</h3>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-end">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Data Order Obat</li>
                </ol>
            </div>
        </div>
    </div>
</div>
<div class="app-content">
    <div class="container-fluid">
        <div class="v_1">
            <div class="card">
                <div class="card-header">Tabel Data Order Obat</div>
                <div class="card-body">
                    <table id="tabelorder" class="table table-sm table-bordered">
                        <thead>
                            <th>Tanggal Order</th>
                            <th>No RM</th>
                            <th>Nama Pasien</th>
                            <th>Nama Dokter</th>
                            <th>Grandtotal</th>
                            <th></th>
                        </thead>
                        <tbody>
                            @foreach ($dataorder as $d )
                            <tr>
                                <td>{{ $d->tglorder}}</td>
                                <td>{{ $d->no_rm}}</td>
                                <td>{{ $d->namapasien}}</td>
                                <td>{{ $d->namadokter}}</td>
                                <td>Rp. {{ number_format($d->grand_total, 0, ',', '.') }}</td>
                                <td>
                                    <button class="btn btn-success detailorder" idheader="{{ $d->idheader }}"><i
                                            class="bi bi-search"></i></button>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div hidden class="v_2">

        </div>
    </div>
</div>
<script>
    $(function() {
        $("#tabelorder").DataTable({
            "responsive": true
            , "lengthChange": false
            , "autoWidth": false
            , "pageLength": 12
            , "searching": true
            , "ordering": false
        , })
    });
    $(".detailorder").on('click', function(event) {
            idheader = $(this).attr('idheader')
            spinner = $('#loader')
            spinner.show();
            $.ajax({
                type: 'post'
                , data: {
                    _token: "{{ csrf_token() }}"
                    , idheader
                }
                , url: '<?= route('ambil_detail_order') ?>'
                , success: function(response) {
                    spinner.hide();
                    $('.v_1').attr('hidden', true)
                    $('.v_2').removeAttr('hidden', true)
                    $('.v_2').html(response);
                }
            });
        });
</script>
@endsection