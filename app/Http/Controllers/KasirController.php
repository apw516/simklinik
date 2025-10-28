<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ts_kunjungan;
use App\Models\ts_layanan_detail;
use App\Models\ts_layanan_header;
use Illuminate\Support\Facades\DB;

class KasirController extends MasterController
{
    Public function indexdatakunjungankasir()
    {
        $menu = 'datakunjungankasir';
        $date = $this->get_date();
        return view('Kasir.indexkdatakunjungan', compact([
            'menu','date'
        ]));
    }
    public function carilayananheader(Request $request)
    {
        $tglawal = $request->tglawal;
        $tglakhir = $request->tglakhir;
        $dataheader = db::select('select * from ts_kunjungan a inner join mt_pasien b on a.no_rm = b.no_rm where date(a.tglentry) between ? and ?',[$tglawal,$tglakhir]);
        return view('Kasir.tabel_data_kunjungan',compact([
            'dataheader'
        ]));
    }
    public function ambildatabilling(Request $request)
    {
        $kode_kunjungan  = $request->kodekunjungan;
        $ts_kunjungan = db::select('select * from ts_kunjungan a inner join mt_pasien b on a.no_rm = b.no_rm where a.kode_kunjungan = ?',[$kode_kunjungan]);
        return view('Kasir.detail_layanan',compact(['ts_kunjungan','kode_kunjungan']));
    }
    public function detailbilling2(Request $request)
    {
        $kode_kunjungan  = $request->kodekunjungan;
        $data_layanan = db::select('select * from ts_layanan_header a inner join ts_layanan_detail b on a.id = b.id_header where a.kode_kunjungan = ? and a.status_layanan_header = ? and b.status_layanan_detail = ?',[$kode_kunjungan,1,1]);
        return view('Kasir.tabel_detail_billing',compact([
            'data_layanan'
        ]));
    }
    public function hitungpembayaran(Request $request)
    {
        $kode_kunjungan = $request->kodekunjungan;
        $tagihan = $request->tagihan;
        $uangbayar = $request->uangbayar;
        $kembalian = $uangbayar - $tagihan;
        if($kembalian < 0){
            echo '<h4 class="text-danger">Uang tidak cukup ! </h4>';
            die;
        }
        $data_header = [
            'kode_kunjungan' => $kode_kunjungan,
            'kode_pembayaran' => 'KSR001',
            'total_tagihan' => $tagihan,
            'uang_diterima' => $uangbayar,
            'kembalian' => $kembalian,
            'status_pembayaran' => 0
        ];
        $data_layanan = db::select('select *,b.id as id_detail from ts_layanan_header a inner join ts_layanan_detail b on a.id = b.id_header where a.kode_kunjungan = ? and b.status_layanan_detail = ? and a.status_layanan_header = ?',[$kode_kunjungan,1,1]);
        foreach($data_layanan as $d){
            $data_detail = [
                'id_kasir_header' => '',
                'idlayananheader' => $d->id_header,
                'kode_layanan_header' => $d->kode_layanan_header,
                'idlayanandetail' => $d->id_detail,
                'nama_layanan' => $d->nama_layanan,
                'total_layanan' => $d->total_tarif,
                'jumlah_layanan' => $d->jumlah_layanan,
            ];
        }
       return view('Kasir.nota_pembayaran',compact([

       ]));
    }
}
