<form class="formeditorderan">
    <div class="mb-3">
        <label for="exampleInputEmail1" class="form-label">Nama Barang</label>
        <input type="text" class="form-control" readonly value="{{ $detail[0]->nama_layanan }}" id="namabarang" name="namabarang"
            aria-describedby="emailHelp">
        <input hidden type="text" class="form-control" readonly value="{{ $detail[0]->iddetail }}" id="iddetail" name="iddetail"
            aria-describedby="emailHelp">
    </div>
    <div class="row">
        <div class="col-md-4">
            <div class="mb-3">
                <label for="exampleInputEmail1" class="form-label">Kode batch</label>
                <input type="text" class="form-control" readonly value="{{ $detail[0]->kodebatch }}"
                    id="kodebatch" name="kodebatch" aria-describedby="emailHelp">
            </div>
        </div>
        <div class="col-md-4">
            <div class="mb-3">
                <label for="exampleInputEmail1" class="form-label">Expired date</label>
                <input type="date" class="form-control" readonly value="{{ $detail[0]->ed }}" id="ed" name="ed"
                    aria-describedby="emailHelp">
            </div>
        </div>
    </div>
    <div class="mb-3">
        <label for="exampleInputEmail1" class="form-label">Sediaan</label>
        <input type="text" class="form-control" readonly value="{{ $detail[0]->sediaan }}" id="sediaan" name="sediaan"
            aria-describedby="emailHelp">
    </div>
    <div class="mb-3">
        <label for="exampleInputEmail1" class="form-label">Aturan Pakai</label>
        <textarea type="text" class="form-control" value="{{ $detail[0]->aturan_pakai }}" id="aturanpakai" name="aturanpakai"
            aria-describedby="emailHelp">{{$detail[0]->aturan_pakai}}</textarea>
    </div>
    <div class="row">
        <div class="col-md-4">
            <div class="mb-3">
                <label for="exampleInputEmail1" class="form-label">QTY Order</label>
                <input type="text" class="form-control" value="{{ $detail[0]->jumlah_layanan }}"
                    id="qtyorder" name="qtyorder" aria-describedby="emailHelp">
            </div>
        </div>
        <div class="col-md-4">
            <div class="mb-3">
                <label for="exampleInputEmail1" class="form-label">Stok tersedia</label>
                <input readonly type="text" class="form-control" value="{{ $detail[0]->stok_current }}"
                    id="stoktersedia" name="stoktersedia" aria-describedby="emailHelp">
            </div>
        </div>
    </div>
    <div class="mb-3">
        <label for="exampleInputEmail1" class="form-label">Jenis Tarif</label>
        <select class="form-select" aria-label="Default select example" name="jenistarif" id="jenistarif">
            <option value="0" @if($detail[0]->jenistarif == 0) selected @endif>Paket</option>
            <option value="1" @if($detail[0]->jenistarif == 1) selected @endif>NON PAKET</option>
        </select>
    </div>
    <div class="mb-3">
        <label for="exampleInputEmail1" class="form-label">Status Order</label>
        <select class="form-select" aria-label="Default select example" name="statusorder" name="statusorder">
            <option value="1" @if($detail[0]->status_layanan_detail == 1) selected @endif>AKTIF</option>
            <option value="2" @if($detail[0]->status_layanan_detail == 2) selected @endif>SELESAI</option>
            <option value="3" @if($detail[0]->status_layanan_detail == 3) selected @endif>BATAL</option>
        </select>
    </div>
</form>
