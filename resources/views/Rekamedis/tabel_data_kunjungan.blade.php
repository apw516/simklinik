        <table id="tabelkunjungan" class="table table-sm table-bordered">
            <thead>
                <th width="10%">Tanggal masuk</th>
                <th width="10%">Nomor rm</th>
                <th>Nama</th>
                <th>Unit</th>
                <th>Dokter</th>
                <th>Status</th>
                <th class="text-center">detail</th>
            </thead>
            <tbody>
                @foreach ($datakunjungan as $D )
                <tr>
                    <td>{{ $D->tanggalkunjungan}}</td>
                    <td>{{ $D->no_rm}}</td>
                    <td>{{ $D->namapasien}}</td>
                    <td>{{ $D->unit}}</td>
                    <td>{{ $D->namadokter}}</td>
                    <td>@if($D->statuskunjungan == 1)Aktif @elseif($D->statuskunjungan == 2) Selesai @elseif($D->statuskunjungan == 3) Batal @endif</td>
                    <td class="text-center">
                        <button class="badge bg-success pilihpasien" kodekunjungan="{{ $D->kode_kunjungan}}" rm="{{ $D->no_rm}}" data-bs-toggle="modal" data-bs-target="#modaldetailkunjungan"><i class="bi bi-journal-arrow-up"></i></button>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        
        <!-- Modal -->
        <div class="modal fade" id="modaldetailkunjungan" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Detail kunjungan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="v_detail">

                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
            </div>
        </div>
        </div>
<script>
    $(function() {
        $("#tabelkunjungan").DataTable({
            "responsive": true
            , "lengthChange": false
            , "autoWidth": false
            , "pageLength": 12
            , "searching": true
            , "ordering": false
        , })
    });
 $(".pilihpasien").on('click', function(event) {
        rm = $(this).attr('rm')
        kodekunjungan = $(this).attr('kodekunjungan')
        spinner = $('#loader')
        spinner.show();
        $.ajax({
            type: 'post'
            , data: {
                _token: "{{ csrf_token() }}"
                , kodekunjungan,rm
            }
            , url: '<?= route('ambildetailkunjungan') ?>'
            , success: function(response) {
                spinner.hide();
                $('.v_detail').html(response);
            }
        });
    });
</script>
