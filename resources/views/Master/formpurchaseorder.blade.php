<div class="card">
    <div class="card-header">Form Purchase Order</div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">Pilih Distributor</div>
                    <div class="card-body">
                        <table id="tbd" class="table table-sm fs-6" id="tabledis">
                            <thead>
                                <th>Nama</th>
                                <th>No Telp</th>
                                <th>Alamat</th>
                                <th>Jenis</th>
                                <th>Action</th>
                            </thead>
                            <tbody>
                                @foreach ($dis as $d )
                                <tr>
                                    <td>{{ $d->nama_perusahaan}}</td>
                                    <td>{{ $d->no_telp}}</td>
                                    <td>{{ $d->alamat}}</td>
                                    <td>{{ $d->jenis_distributor}}</td>
                                    <td>
                                        <button class="badge bg-success pilidist" telp="{{ $d->no_telp }}" iddist="{{ $d->id }}" namadist="{{ $d->nama_perusahaan }}" jenis="{{ $d->jenis_distributor }}" alamat="{{ $d->alamat }}"><i class="bi bi-check2-square"></i></button>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Pilih Master Barang</div>
                    <div class="card-body">
                        <div class="v_tb_barang">

                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row mt-2">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">Data Purchase Order</div>
                    <div class="card-body">
                        <div class="card">
                            <div class="card-header">Data Distributor</div>
                            <div class="card-body">
                                <form action="" class="datadistributor">
                                    <div class="row">
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="exampleInputEmail1">Tanggal Purchase Order</label>
                                                <input type="date" class="form-control" id="tglpo" name="tglpo" aria-describedby="emailHelp">
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="exampleInputEmail1">Nama Distributor</label>
                                                <input readonly type="email" class="form-control" id="namadistributor" name="namadistributor" aria-describedby="emailHelp">
                                                <input hidden type="email" class="form-control" id="iddistributor" name="iddistributor" aria-describedby="emailHelp">
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="exampleInputEmail1">No Telp</label>
                                                <input type="email" class="form-control" id="notelp" name="notelp" aria-describedby="emailHelp">
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="exampleInputEmail1">Alamat</label>
                                                <input readonly type="email" class="form-control" id="alamat" name="alamat" aria-describedby="emailHelp">
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="exampleInputEmail1">Jenis</label>
                                                <input readonly type="email" class="form-control" id="jenis" name="jenis" aria-describedby="emailHelp">
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="card mt-2">
                            <div class="card-header">Data Barang</div>
                            <div class="card-body">
                                <div class="row">
                                    <form action="" method="post" class="arraybarang">
                                        <div class="formobatfarmasi2">

                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button class="btn btn-danger">Batal</button>
                        <button class="btn btn-success"  onclick="simpanpo()">Simpan Purchase Order</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $(function() {
        $("#tbd").DataTable({
            "responsive": true
            , "lengthChange": false
            , "autoWidth": false
            , "pageLength": 12
            , "searching": true
            , "ordering": false
        , })
    });
    $(".pilidist").on('click', function(event) {
        id = $(this).attr('iddist')
        spinner = $('#loader')
        spinner.show();
        a = $(this).attr('telp')
        b = $(this).attr('iddist')
        c = $(this).attr('namadist')
        d = $(this).attr('jenis')
        e = $(this).attr('alamat')
        $('#namadistributor').val(c)
        $('#notelp').val(a)
        $('#alamat').val(e)
        $('#jenis').val(d)
        $('#iddistributor').val(id)
        $.ajax({
            type: 'post'
            , data: {
                _token: "{{ csrf_token() }}"
                , id
            }
            , url: '<?= route('ambilbarangdistributor') ?>'
            , success: function(response) {
                spinner.hide();
                $('.v_tb_barang').html(response);
            }
        });
    });

    function simpanpo() {
        Swal.fire({
            title: "Anda yakin ?"
            , text: "Data Purchase order akan disimpan!"
            , icon: "question"
            , showCancelButton: true
            , confirmButtonColor: "#3085d6"
            , cancelButtonColor: "#d33"
            , confirmButtonText: "Ya Simpan ..."
        }).then((result) => {
            if (result.isConfirmed) {
                var data1 = $('.datadistributor').serializeArray();
                var data2 = $('.arraybarang').serializeArray();
                spinner = $('#loader')
                spinner.show();
                $.ajax({
                    async: true
                    , type: 'post'
                    , dataType: 'json'
                    , data: {
                        _token: "{{ csrf_token() }}"
                        , data1: JSON.stringify(data1)
                        , data2: JSON.stringify(data2)
                    }
                    , url: '<?= route('simpanpurchaseorder') ?>'
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
                            const myForm = document.getElementById('formpendaftaranpasien');
                            myForm.reset();
                        }
                    }
                });
            }
        });
    }

</script>
