<h5>Uang yang dibayarkan tidak cukup ! 
    <button class="btn btn-success" onclick="reload()"><i class="bi bi-arrow-clockwise"></i></button>
    <button class="btn btn-danger" onclick="batalbayar()"><i class="bi bi-x"></i></button>
</h5>
<script>
    function reload()
    {
        $('.btnhitung').removeAttr('disabled',true)
        $('#uangbayar').removeAttr('readonly',true)
        $('#uangbayar').val(0)
    }
    function batalbayar()
    {
        $('.v_pembayaran').attr('hidden',true)
        $('.btnterima').removeAttr('disabled',true)
        $('.btnretur').removeAttr('disabled',true)
        $('.btnhitung').removeAttr('disabled',true)
        $('#uangbayar').removeAttr('readonly',true)
        $('#uangbayar').val(0)
    }
</script>