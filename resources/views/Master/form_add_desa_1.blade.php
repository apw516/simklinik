<form action="" class="formaddkecamatan">
    <div class="mb-3">
        <label for="exampleFormControlInput1" class="form-label">Pilih Kabupaten</label>
        <select class="form-select" aria-label="Default select example" id="kodekab" onchange="cari()">
            <option>Silahkan Pilih</option>
            @foreach ($kabupaten as $D )
            <option value="{{ $D->code }}" >{{ $D->name }}</option>
            @endforeach
        </select>
    </div>
    <div class="v_for_list_kecamatan">

    </div>
</form>
<script>
    function cari()
    {
        idkab = $('#kodekab').val()
        spinner = $('#loader')
        spinner.show();
        $.ajax({
            type: 'post'
            , data: {
                _token: "{{ csrf_token() }}"
                , idkab
            }
            , url: '<?= route('ambil_kecamatan') ?>'
            , success: function(response) {
                spinner.hide();
                $('.v_for_list_kecamatan').html(response);
            }
        });
    }
</script>