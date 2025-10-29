
<button class="btn btn-danger mb-3" onclick="kembali()"><i class="bi bi-backspace-fill"></i> Kembali</button>
<input hidden type="text" id="kode_kunjungan" value="{{ $kode_kunjungan}}">
<div class="card">
    <div class="card-header">Detail Billing
        <table class="mt-3">
            <tr>
                <td>Nomor RM</td>
                <td> : {{ $ts_kunjungan[0]->no_rm}}</td>
            </tr>
            <tr>
                <td>Nama Pasien</td>
                <td> : {{ $ts_kunjungan[0]->namapasien}}</td>
            </tr>
            <tr>
                <td>Unit</td>
                <td> : {{ $ts_kunjungan[0]->unit}}</td>
            </tr>
        </table>
    </div>
    <div class="card-body">
        <div class="v_detail">

        </div>       
    </div>
    <div class="card-footer">
        <button class="btn btn-success float-end ms-1 me-1 btnterima" onclick="terima()"><i class="bi bi-cloud-download-fill"></i> Terima </button>
        <button class="btn btn-danger float-end ms-1 me-1 btnretur"><i class="bi bi-x"></i> Retur </button>
    </div>
</div>

<div hidden class="card mt-2 v_pembayaran">
    <div class="card-header">Form Pembayaran</div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-2">
                <label for="">Total Tagihan</label>
                <input readonly type="text" id="totaltagihan" readonly class="form-control" placeholder="Total tagihan ...">
                <input hidden type="text" id="totaltagihan2" readonly class="form-control" placeholder="Total tagihan ...">
            </div>
            <div class="col-md-3">
                <label for="">Uang yang diberikan</label>
                <input type="text" id="uangbayar" class="form-control" placeholder="Masukan uang yang diberikan pasien ..." value="0">
            </div>
            <div class="col-md-3">
                <button class="btn btn-success btnhitung" style="margin-top:26px" onclick="hitungpembayaran()"><i class="bi bi-cloud-download-fill"></i> Proses ...</button>
            </div>
        </div>
        <div class="v_nota_pembayaran">

        </div>
    </div>
</div>
<script>
     $(document).ready(function() {
            ambildetail()
     })
    function ambildetail()
    {
        kodekunjungan = $('#kode_kunjungan').val()
        spinner = $('#loader')
        spinner.show();
            $.ajax({
                type: 'post'
                , data: {
                    _token: "{{ csrf_token() }}"
                    , kodekunjungan
                }
                , url: '<?= route('detailbilling2') ?>'
                , success: function(response) {
                    spinner.hide();
                    $('.v_detail').html(response);
                }
            });
    }
    function terima()
    {
        total = $('#grandtotalbilling2').val()
        total2 = $('#grandtotalbilling').val()
        $('.v_pembayaran').removeAttr('hidden',true)
        $('#totaltagihan').val(total)
        $('#totaltagihan2').val(total2)
    }
    function hitungpembayaran()
    {
       kodekunjungan = $('#kode_kunjungan').val()
       tagihan = $('#totaltagihan2').val()
       uangbayar = $('#uangbayar').val()
        spinner = $('#loader')
        spinner.show();
       spinner = $('#loader')
        spinner.show();
        $.ajax({
            type: 'post'
            , data: {
                _token: "{{ csrf_token() }}"
                , kodekunjungan,tagihan,uangbayar
            }
            , url: '<?= route('hitungpembayaran') ?>'
            , success: function(response) {
                spinner.hide();
                $('.v_nota_pembayaran').html(response);
                $('.btnhitung').attr('disabled',true)
                $('.btnterima').attr('disabled',true)
                $('.btnretur').attr('disabled',true)               
                $('#uangbayar').attr('readonly',true)
            }
        });
    }
</script>