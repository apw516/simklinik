<div class="card">
    <div class="card-header">Detail Order Obat</div>
    <div class="card-body">
        <button class="btn btn-danger mb-3" onclick="kembali()"><i class="bi bi-backspace-fill"></i> Kembali</button>
        <input hidden type="text" value="{{ $idheader }}" id="idheader">
        <div class="v_tabel_order">

        </div>
        <div class="card mt-2">
            <div class="card-header">Cari Obat ...</div>
            <div class="card-body">
                <div class="card">
                    <div class="card-header">Silahkan Pilih obat</div>
                    <div class="card-body">
                        <table id="tabelobat" class="table table sm text-xs" style="font-size: 10px">
                            <thead>
                                <th>Nama</th>
                                <th>Harga beli satuan</th>
                                <th>Stok</th>
                                <th>ed</th>
                                <th></th>
                            </thead>
                            <tbody>
                                @foreach ($mt_stok as $t)
                                    <tr>
                                        <td>{{ $t->nama_barang }}</td>
                                        <td>Rp. {{ number_format($t->harga_beli_satuan_kecil, 0, ',', '.') }}
                                        </td>
                                        <td>{{ $t->stok_current }}</td>
                                        <td>{{ \Carbon\Carbon::parse($t->ed)->format('d-M-Y') }}</td>
                                        <td>
                                            <button idstok="{{ $t->id }}"
                                                harga1="Rp. {{ number_format($t->harga_beli_satuan_kecil, 0, ',', '.') }}"
                                                harga2="{{ $t->harga_beli_satuan_kecil }}" nama="{{ $t->nama_barang }}"
                                                class="badge bg-success pilihobat"><i
                                                    class="bi bi-check2-circle"></i></button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card mt-1">
                    <div class="card-header">List obat yang dipilih</div>
                    <div class="card-body">
                        <form action="" method="post" class="formresep">
                            <div class="draftresep">
                                <div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="card-footer">
        <button class="btn btn-success mb-1" onclick="terimaorderan()"><i class="bi bi-download"></i> Simpan</button>
        <button class="btn btn-danger mb-1" onclick="kembali()"><i class="bi bi-backspace-fill"></i> Kembali</button>

    </div>
</div>
<script>
    function kembali() {
        location.reload()
    }
    $(document).ready(function() {
        get_data_order()
    });

    function get_data_order() {
        idheader = $('#idheader').val()
        spinner = $('#loader')
        spinner.show();
        $.ajax({
            type: 'post',
            data: {
                _token: "{{ csrf_token() }}",
                idheader
            },
            url: '<?= route('ambildataorder') ?>',
            success: function(response) {
                spinner.hide();
                $('.v_tabel_order').html(response);
            }
        });
    }
    $(".pilihobat").on('click', function(event) {
        idstok = $(this).attr('idstok')
        nama = $(this).attr('nama')
        harga1 = $(this).attr('harga1')
        harga2 = $(this).attr('harga2')
        var wrapper = $(".draftresep");
        $(wrapper).append(
            '<div class="row text-xs"><div class="form-group col-md-2"><label for="">Nama Tarif</label><input readonly type="" class="form-control form-control-sm text-xs edit_field" id="namabarang" name="namabarang" value="' +
            nama +
            '"><input   hidden readonly type="" class="form-control form-control-sm" id="kodestok" name="kodestok" value="' +
            idstok +
            '"><input   hidden readonly type="" class="form-control form-control-sm" id="harga2" name="harga2" value="' +
            harga2 +
            '"></div><div class="form-group col-md-2"><label for="">Harga</label><input readonly type="" class="form-control form-control-sm text-xs edit_field" id="harga" name="harga" value="' +
            harga1 +
            '"></div><div class="form-group col-md-2"><label for="">Jenis Tarif</label><select class="form-select" aria-label="Default select example" name="jenistarif" id="jenistarif"><option selected value="0">Tarif Paket</option><option value="1">NON PAKET</option></select></div><div class="form-group col-md-1"><label for="">qty</label><input type="" class="form-control form-control-sm text-xs edit_field" id="qty" name="qty" value=""></div><div class="form-group col-md-3"><label for="">Aturan Pakai</label><textarea type="" class="form-control form-control-sm text-xs edit_field" id="aturanpakai" name="aturanpakai" value=""></textarea></div><i class="bi bi-x-square remove_field form-group col-md-1 text-danger" kode2=""></i></div>'
        );
        Swal.fire({
            title: "Obat dipilih " + nama,
            text: "ok!",
            icon: "success"
        });
        $(wrapper).on("click", ".remove_field", function(e) { //user click on remove
            e.preventDefault();
            $(this).parent('div').remove();
            x--;
        })
    });

    function terimaorderan() {
        idheader = $('#idheader').val()
        var data3 = $('.formresep').serializeArray();
        spinner = $('#loader')
        spinner.show();
        $.ajax({
            async: true,
            type: 'post',
            dataType: 'json',
            data: {
                _token: "{{ csrf_token() }}",
                data3: JSON.stringify(data3),
                idheader
            },
            url: '<?= route('terimaorderanobat') ?>',
            error: function(data) {
                spinner.hide()
                Swal.fire({
                    icon: 'error',
                    title: 'Ooops....',
                    text: 'Sepertinya ada masalah......',
                    footer: ''
                })
            },
            success: function(data) {
                spinner.hide()
                if (data.kode == 500) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oopss...',
                        text: data.message,
                        footer: ''
                    })
                } else {
                    Swal.fire({
                        icon: 'success',
                        title: 'OK',
                        text: data.message,
                        footer: ''
                    })
                }
            }
        });
    }
</script>
