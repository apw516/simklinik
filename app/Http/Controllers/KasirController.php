<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ts_kunjungan;
use App\Models\ts_layanan_detail;
use App\Models\ts_layanan_header;
use App\Models\ts_transaksi_kasir_detail;
use App\Models\ts_transaksi_kasir_header;
use Illuminate\Support\Facades\DB;

class KasirController extends MasterController
{
    public function indexdatakunjungankasir()
    {
        $menu = 'datakunjungankasir';
        $date = $this->get_date();
        return view('Kasir.indexkdatakunjungan', compact([
            'menu',
            'date'
        ]));
    }
    public function indexriwayatpembayaran()
    {
        $menu = 'riwayatpembayaran';
        $date = $this->get_date();
        return view('Kasir.indexriwayatpembayaran', compact([
            'menu',
            'date'
        ]));
    }
    public function caririwayatpembayaran(Request $request)
    {
        $tglawal = $request->tglawal;
        $tglakhir = $request->tglakhir;
        $datakasir = db::select('select *,date(b.tgl_entry) as tgll from ts_kunjungan a inner join ts_transaksi_kasir_header b on a.kode_kunjungan = b.kode_kunjungan where date(b.tgl_entry) between ? and ? AND a.statuskunjungan != ? and b.status_pembayaran = ?', [$tglawal, $tglakhir,3,1]);
        return view('Kasir.tabel_riwayat_pembayaran', compact([
            'datakasir'
        ]));
    }
    public function carilayananheader(Request $request)
    {
        $tglawal = $request->tglawal;
        $tglakhir = $request->tglakhir;
        $dataheader = db::select('select * from ts_kunjungan a inner join mt_pasien b on a.no_rm = b.no_rm where date(a.tglentry) between ? and ? AND a.statuskunjungan = ?', [$tglawal, $tglakhir,1]);
        return view('Kasir.tabel_data_kunjungan', compact([
            'dataheader'
        ]));
    }
    public function ambildatabilling(Request $request)
    {
        $kode_kunjungan  = $request->kodekunjungan;
        $ts_kunjungan = db::select('select * from ts_kunjungan a inner join mt_pasien b on a.no_rm = b.no_rm where a.kode_kunjungan = ?', [$kode_kunjungan]);
        return view('Kasir.detail_layanan', compact(['ts_kunjungan', 'kode_kunjungan']));
    }
    public function detailbilling2(Request $request)
    {
        $kode_kunjungan  = $request->kodekunjungan;
        $data_layanan = db::select('select * from ts_layanan_header a inner join ts_layanan_detail b on a.id = b.id_header where a.kode_kunjungan = ? and a.status_layanan_header = ? and b.status_layanan_detail = ? and a.status_pembayaran = 0', [$kode_kunjungan, 1, 1]);
        return view('Kasir.tabel_detail_billing', compact([
            'data_layanan'
        ]));
    }
    public function hitungpembayaran(Request $request)
    {
        $kode_kunjungan = $request->kodekunjungan;
        $tagihan = $request->tagihan;
        $uangbayar = $request->uangbayar;
        $kembalian = $uangbayar - $tagihan;
        if ($kembalian < 0) {
            return view('Kasir.error');
        }
        $KODE = $this->get_kasir_header();
        $data_layanan = db::select('select *,b.id as id_detail from ts_layanan_header a inner join ts_layanan_detail b on a.id = b.id_header where a.kode_kunjungan = ? and b.status_layanan_detail = ? and a.status_layanan_header = ?', [$kode_kunjungan, 1, 1]);
        $data_header = [
            'kode_kunjungan' => $kode_kunjungan,
            'kode_pembayaran' => $KODE,
            'total_tagihan' => $tagihan,
            'uang_diterima' => $uangbayar,
            'kembalian' => $kembalian,
            'status_pembayaran' => 0,
            'pic' => auth()->user()->id,
            'tgl_entry' => $this->get_now()
        ];
        $hd = ts_transaksi_kasir_header::create($data_header);
        foreach ($data_layanan as $d) {
            $data_detail = [
                'id_kasir_header' => $hd->id,
                'idlayananheader' => $d->id_header,
                'kode_layanan_header' => $d->kode_layanan_header,
                'id_tarif' => $d->idlayanan,
                'idlayanandetail' => $d->id_detail,
                'nama_layanan' => $d->nama_layanan,
                'total_layanan' => $d->total_tarif,
                'jumlah_layanan' => $d->jumlah_layanan,
            ];
            ts_transaksi_kasir_detail::create($data_detail);
        }
        $data_ts_kasir = db::select('select * from ts_transaksi_kasir_header a inner join ts_transaksi_kasir_detail b on a.id = b.id_kasir_header where a.id = ?', [$hd->id]);
        $id_kasir = $hd->id;
        return view('Kasir.nota_pembayaran', compact([
            'data_ts_kasir',
            'id_kasir'
        ]));
    }
    public function batalbayar(Request $request)
    {
        $id = $request->kode;
        ts_transaksi_kasir_header::where('id', $id)
            ->delete();
        ts_transaksi_kasir_detail::where('id_kasir_header', $id)
            ->delete();
        $data2 = [
            'kode' => 200,
            'message' => 'Pembayaran dibatalkan !'
        ];
        echo json_encode($data2);
        die;
    }
    public function simpanpembayaran(Request $request)
    {
        $id = $request->kode;
        ts_transaksi_kasir_header::where('id', $id)->update(['status_pembayaran' => 1]);
        $detail = db::select('select * from ts_transaksi_kasir_detail where id_kasir_header = ?',[$id]);
        foreach($detail as $dd){
            $id_layanan_header = $dd->idlayananheader;
            ts_layanan_header::where('id', $id_layanan_header)->update(['status_pembayaran' => 1]);
        }        
        $dc = db::select('select * from ts_transaksi_kasir_header where id = ?',[$id]);
        $kode_kunjungan = $dc[0]->kode_kunjungan;
        $cek_layanan_header = db::select('select * from ts_layanan_header where kode_kunjungan = ? and status_pembayaran = ?',[$kode_kunjungan,0]);
        if(count($cek_layanan_header) == 0){
            ts_kunjungan::where('kode_kunjungan', $kode_kunjungan)->update(['statuskunjungan' => 2]);
        }
        $data2 = [
            'kode' => 200,
            'message' => 'Pembayaran berhasil !'
        ];
        echo json_encode($data2);
        die;
    }
    public function get_kasir_header()
    {
        $q = DB::select('SELECT id,RIGHT(kode_pembayaran,3) AS kd_max  FROM ts_transaksi_kasir_header
        WHERE date(tgl_entry) = ?
        ORDER BY id DESC
        LIMIT 1', [$this->get_date()]);
        $kd = "";
        if (count($q) > 0) {
            foreach ($q as $k) {
                $tmp = ((int) $k->kd_max) + 1;
                $kd = sprintf("%03s", $tmp);
            }
        } else {
            $kd = "001";
        }
        date_default_timezone_set('Asia/Jakarta');
        return 'KSR' . str_replace('-', '', $this->get_date()) . $kd;
    }
}
