<div class="card">
    <div class="card-header">Data PO</div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-2">
                Tanggal PO
            </div>
            <div class="col-md-4">
                : {{ $detail[0]->tanggal_po}}
            </div>
        </div>
        <div class="row">
            <div class="col-md-2">
                Nama Distributor
            </div>
            <div class="col-md-4">
                : {{ $detail[0]->namadistributor}}
            </div>
        </div>
        <div class="row">
            <div class="col-md-2">
                Alamat Distributor
            </div>
            <div class="col-md-4">
                : {{ $detail[0]->alamat}}
            </div>
        </div>
        <div class="row">
            <div class="col-md-2">
                No telp
            </div>
            <div class="col-md-4">
                : {{ $detail[0]->notelp}}
            </div>
        </div>
        <div class="row">
            <div class="col-md-2">
                Jenis PO
            </div>
            <div class="col-md-4">
                : {{ $detail[0]->jenis}}
            </div>
        </div>
        <div class="row">
            <div class="col-md-2">
                Tanggal Terima
            </div>
            <div class="col-md-4">
                <div class="form-group row">
                    <label for="inputPassword" class="col-sm-1 col-form-label">:</label>
                    <div class="col-sm-10">
                        <input type="date" class="form-control" id="tanggalterima">
                        <input hidden type="text" class="form-control" id="idheader" value="{{ $detail[0]->idheader }}">
                    </div>
                </div>
            </div>
        </div>
        <div class="row mt-2">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">Detail Barang</div>
                    <div class="card-body">
                        <form action="" class="formdetailbarang">
                            @foreach ($detail as $d )
                            <div class="row text-xs">
                                <div class="form-group col-md-2"><label for="">Nama Barang</label><input readonly type="" class="form-control form-control-sm text-xs" id="" name="namabarang" value="{{ $d->namabarang}}"></div>
                                <div hidden class="form-group col-md-2"><label for="">Nama Generik</label><input readonly type="" class="form-control form-control-sm text-xs" id="" name="kodebarang" value="{{ $d->idbarang}}"><input readonly hidden type="" class="form-control form-control-sm text-xs" id="" name="iddetail" value="{{ $d->iddetail}}">
                                </div>
                                <div hidden class="form-group col-md-1"><label for="">Jenis Barang</label><input readonly type="" class="form-control form-control-sm text-xs" id="" name="jenis" value="{{ $d->jenis}}">
                                </div>
                                <div class="form-group col-md-1"><label for="">Satuan</label><input type="" readonly class="form-control form-control-sm text-xs" id="" name="satuan" value="{{ $d->satuan}}">
                                </div>
                                <div class="form-group col-md-1"><label for="">isi</label><input type="" class="form-control form-control-sm text-xs" id="" name="isi" readonly value="{{ $d->isi}}"></div>
                                <div class="form-group col-md-1"><label for="">Sediaan</label><input type="" readonly class="form-control form-control-sm text-xs" id="" name="sediaan" value="{{ $d->sediaan}}"></div>
                                <div class="form-group col-md-2"><label for="">Expired date</label><input type="date" class="form-control form-control-sm text-xs" id="" name="ed" value=""></div>
                                <div class="form-group col-md-1"><label for="">Kode Batch</label><input type="" class="form-control form-control-sm text-xs" id="" name="kodebatch" value=""></div>
                                <div class="form-group col-md-1"><label for="">Harga Satuan</label><input type="" class="form-control form-control-sm text-xs" id="" name="hargasatuan" value=""></div>
                                <div class="form-group col-md-1"><label for="">Grandtotal</label><input type="" class="form-control form-control-sm text-xs" id="" name="grandtotal" value=""></div>
                                <div class="form-group col-md-1"><label for="">Jumlah PO</label><input type="" readonly class="form-control form-control-sm text-xs" id="" name="jumlahpo" value="{{ $d->jumlah_po}}"></div>
                                <div class="form-group col-md-1"><label for="">Jumlah Terima</label><input type="" class="form-control form-control-sm text-xs" id="" name="jumlahterima" value=""></div><i class="bi bi-x-square remove_field form-group col-md-1 text-danger"></i>
                            </div>
                            @endforeach
                        </form>
                    </div>
                    <div class="card-footer">
                        <button class="btn btn-success" onclick="simpandataterima()"><i class="bi bi-floppy"></i> Simpan</button>
                        <button class="btn btn-danger mr-1 ml-1" onclick="kembali()"><i class="bi bi-x"></i> Batal</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {
        var wrapper = $(".formdetailbarang"); //Fields wrapper
        $(wrapper).on("click", ".remove_field", function(e) { //user click on remove
            kode = $(this).attr('kode2')
            e.preventDefault();
            $(this).parent('div').remove();
            x--;
        })
    });
function simpandataterima()
{
     Swal.fire({
            title: "Anda yakin ?"
            , text: "Data Purchase order akan diterima !"
            , icon: "question"
            , showCancelButton: true
            , confirmButtonColor: "#3085d6"
            , cancelButtonColor: "#d33"
            , confirmButtonText: "Ya Simpan ..."
        }).then((result) => {
            if (result.isConfirmed) {
                var data2 = $('.formdetailbarang').serializeArray();
                tglterima = $('#tanggalterima').val()
                idheader = $('#idheader').val()
                spinner = $('#loader')
                spinner.show();
                $.ajax({
                    async: true
                    , type: 'post'
                    , dataType: 'json'
                    , data: {
                        _token: "{{ csrf_token() }}"
                        , data2: JSON.stringify(data2),tglterima,idheader
                    }
                    , url: '<?= route('simpandataterimapo') ?>'
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
                            location.reload()
                        }
                    }
                });
            }
        });
}
</script>
