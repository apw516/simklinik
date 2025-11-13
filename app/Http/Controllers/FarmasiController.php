<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use Carbon\Carbon;
class FarmasiController extends Controller
{
    public function indexdataorder()
    {
        $menu = 'dataorderobat';
        $dataorder =  db::select('select *,b.tgl_entry as tglorder,b.id as idheader from ts_kunjungan a inner join ts_layanan_header b on a.kode_kunjungan = b.kode_kunjungan inner join mt_pasien c on a.no_rm = c.no_rm where b.status_layanan_header = ? and jenis = ? order by b.id desc',['1','OBAT']);
        return view('Farmasi.indexdataorderobat', compact([
            'menu',
            'dataorder'
        ]));
    }
    public function ambildetailorder(request $request){
        $test = '123';
        $idheader = $request->idheader;
        $detail = db::select('select * from ts_layanan_detail a inner join mt_sediaan_barang b on a.idlayanan = b.id where a.id_header = ?',[$idheader]);
        return view('Farmasi.detail_order',compact([
            'detail'
        ]));
    }
}
