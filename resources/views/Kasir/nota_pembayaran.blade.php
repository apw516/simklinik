<div class="v_nota mt-2">
    <div class="card">
        <div class="card-header">Nota Pembayaran</div>
        <div class="card-body">
            <table class="table table-sm">
                <thead>
                    <th>Kode Pembayaran</th>
                    <th>Nama Layanan</th>
                    <th>Jumlah Layanan</th>
                    <th>Total Layanan</th>
                </thead>
                <tbody>
                    @foreach ($data_ts_kasir as $d)
                    <tr>
                        <td>{{ $d->kode_pembayaran}}</td>
                        <td>{{ $d->nama_layanan}}</td>
                        <td>{{ $d->jumlah_layanan}}</td>
                        <td>Rp. {{ number_format($d->total_layanan, 0, ',', '.') }}</td>
                    </tr>
                    @endforeach
                    <tr class="table-secondary">
                        <td colspan="3" class="text-end fw-bold">Uang diterima</td>
                        <td class="text-end fst-italic fw-bold">Rp. {{ number_format($data_ts_kasir[0]->uang_diterima, 0, ',', '.') }}</td>
                    </tr>
                    <tr class="table-secondary">
                        <td colspan="3" class="text-end fw-bold">Grand Total</td>
                        <td class="text-end fst-italic fw-bold">Rp. {{ number_format($data_ts_kasir[0]->total_tagihan, 0, ',', '.') }}</td>
                    </tr>
                    <tr class="table-secondary">
                        <td colspan="3" class="text-end fw-bold">Kembalian</td>
                        <td class="text-end fst-italic fw-bold">Rp. {{ number_format($data_ts_kasir[0]->kembalian, 0, ',', '.') }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
        <input hidden id="kodepembayaran" type="text" value="{{ $id_kasir }}">
        <div class="card-footer">
            <button class="btn btn-success BAYAR" onclick="bayartagihan1()"><i class="bi bi-cash-coin"></i> Bayar</button>
            <button class="btn btn-danger BATALBAYAR" onclick="batalbayar()"><i class="bi bi-x"></i> Batal</button>
            <button hidden class="btn btn-danger isbek" onclick="kembali()"><i class="bi bi-backspace-fill"></i> Kembali</button>
        </div>
    </div>
</div>
<script>
    function batalbayar()
    {
        $('.v_pembayaran').attr('hidden',true)
        $('.btnterima').removeAttr('disabled',true)
        $('.btnretur').removeAttr('disabled',true)
        $('.btnhitung').removeAttr('disabled',true)
        $('#uangbayar').removeAttr('readonly',true)
        $('#uangbayar').val(0)
        kode = $('#kodepembayaran').val()
        $('.v_nota_pembayaran').empty()   
        spinner = $('#loader')
        spinner.show();
        $.ajax({
            async: true
            , type: 'post'
            , dataType: 'json'
            , data: {
                _token: "{{ csrf_token() }}"
                , kode
            , }
            , url: '<?= route('batalbayar') ?>'
            , error: function(data) {
                spinner.hide()
                Swal.fire({
                    icon: 'error'
                    , title: 'Ooops....'
                    , text: 'Sepertinya ada masalah......'
                    , footer: ''
                })
            }
            , success: function(data) {
                spinner.hide()
                if (data.kode == 500) {
                    Swal.fire({
                        icon: 'error'
                        , title: 'Oopss...'
                        , text: data.message
                        , footer: ''
                    })
                } else {
                    Swal.fire({
                        icon: 'success'
                        , title: 'OK'
                        , text: data.message
                        , footer: ''
                    })
                }
            }
        });
    }
    function bayartagihan1()
    {
        Swal.fire({
            title: "Anda yakin ?"
            , text: "Data pembayaran akan disimpan !"
            , icon: "question"
            , showCancelButton: true
            , confirmButtonColor: "#3085d6"
            , cancelButtonColor: "#d33"
            , confirmButtonText: "Ya Simpan ..."
        }).then((result) => {
            if (result.isConfirmed) {
                bayartagihan()
            }
        });
    }
    function bayartagihan()
    {
        kode = $('#kodepembayaran').val()
        spinner = $('#loader')
        spinner.show();
        $.ajax({
            async: true
            , type: 'post'
            , dataType: 'json'
            , data: {
                _token: "{{ csrf_token() }}"
                , kode
            , }
            , url: '<?= route('simpanpembayaran') ?>'
            , error: function(data) {
                spinner.hide()
                Swal.fire({
                    icon: 'error'
                    , title: 'Ooops....'
                    , text: 'Sepertinya ada masalah......'
                    , footer: ''
                })
            }
            , success: function(data) {
                spinner.hide()
                if (data.kode == 500) {
                    Swal.fire({
                        icon: 'error'
                        , title: 'Oopss...'
                        , text: data.message
                        , footer: ''
                    })
                } else {
                    $('.BAYAR').attr('disabled',true)
                    $('.BATALBAYAR').attr('disabled',true)
                    $('.isbek').removeAttr('hidden',true)
                     Swal.fire({
                        title: "Pembayarn berhasil, cetak nota pembayaran ?"
                        , text: "Nota pembayaran akan dicetak ..."
                        , icon: "success"
                        , showCancelButton: true
                        , confirmButtonColor: "#3085d6"
                        , cancelButtonColor: "#d33"
                        , confirmButtonText: "Ya cetak ..."
                    }).then((result) => {
                        if (result.isConfirmed) {
                            
                        }
                    });                    
                }
            }
        });
    }
</script>