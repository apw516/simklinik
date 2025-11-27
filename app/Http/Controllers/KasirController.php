<?php

namespace App\Http\Controllers;

use App\Models\ts_kasir_retur_detail;
use App\Models\ts_kasir_retur_header;
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
        $datakasir = db::select('select *,date(b.tgl_entry) as tgll,b.id as idkasirheader,c.namapasien,b.status_pembayaran as spk from ts_kunjungan a inner join ts_transaksi_kasir_header b on a.kode_kunjungan = b.kode_kunjungan inner join mt_pasien c on a.no_rm = c.no_rm where date(b.tgl_entry) between ? and ? AND a.statuskunjungan != ?', [$tglawal, $tglakhir, 3]);
        return view('Kasir.tabel_riwayat_pembayaran', compact([
            'datakasir'
        ]));
    }
    public function bayarlayananheader(Request $request)
    {
        $id = $request->idkasirheader;
        ts_transaksi_kasir_header::where('id', $id)->update(['status_pembayaran' => 1]);
        $detail = db::select('select * from ts_transaksi_kasir_detail where id_kasir_header = ?', [$id]);
        foreach ($detail as $dd) {
            $id_layanan_header = $dd->idlayananheader;
            ts_layanan_header::where('id', $id_layanan_header)->update(['status_pembayaran' => 1]);
        }
        $dc = db::select('select * from ts_transaksi_kasir_header where id = ?', [$id]);
        $kode_kunjungan = $dc[0]->kode_kunjungan;
        $cek_layanan_header = db::select('select * from ts_layanan_header where kode_kunjungan = ? and status_pembayaran = ? and status_layanan_header = ?', [$kode_kunjungan, 0, 1]);
        if (count($cek_layanan_header) == 0) {
            ts_kunjungan::where('kode_kunjungan', $kode_kunjungan)->update(['statuskunjungan' => 2]);
        }
        $data2 = [
            'kode' => 200,
            'message' => 'Pembayaran berhasil !'
        ];
        echo json_encode($data2);
        die;
    }
    public function carilayananheader(Request $request)
    {
        $tglawal = $request->tglawal;
        $tglakhir = $request->tglakhir;
        $dataheader = db::select('select * from ts_kunjungan a inner join mt_pasien b on a.no_rm = b.no_rm where date(a.tglentry) between ? and ? AND a.statuskunjungan = ?', [$tglawal, $tglakhir, 1]);
        return view('Kasir.tabel_data_kunjungan', compact([
            'dataheader'
        ]));
    }
    public function ambildetailpembayaran(Request $request)
    {
        $idkasirheader  = $request->idkasirheader;
        $detail = db::select('select *,a.status_pembayaran as spk from ts_transaksi_kasir_header a inner join ts_transaksi_kasir_detail b on a.id = b.id_kasir_header where a.id  = ?', [$idkasirheader]);
        return view('Kasir.detail_pembayaran', compact([
            'detail',
            'idkasirheader'
        ]));
    }
    public function batalpembayaran(Request $request)
    {
        $idpembayaran = $request->idpembayaran;
        $header = db::select('select * from ts_transaksi_kasir_header where id = ?', [$idpembayaran]);
        $kode_kunjungan = $header[0]->kode_kunjungan;
        $detail = db::select('select * from ts_transaksi_kasir_detail where id_kasir_header = ?', [$idpembayaran]);
        $kodeh = $this->get_kasir_retur_header();
        $retur_header = [
            'id_kasir_header' => $idpembayaran,
            'kode_kunjungan' => $kode_kunjungan,
            'total_retur' => $header[0]->total_tagihan,
            'kode_retur_header' => $kodeh,
            'pic' => auth()->user()->id,
            'tgl_entry' => $this->get_now()
        ];
        $trh = ts_kasir_retur_header::create($retur_header);
        foreach ($detail as $d) {
            $detail = [
                'id_retur_header' => $trh->id,
                'id_layanan_header' => $d->idlayananheader,
                'id_layanan_detail' => $d->idlayanandetail,
                'id_tarif' => $d->id_tarif,
                'nama_tarif' => $d->nama_layanan,
                'total_layanan' => $d->total_layanan
            ];
            ts_kasir_retur_detail::create($detail);
            ts_transaksi_kasir_detail::where('id', $d->id)
            ->update(['status_pembayaran' => 3]);
            ts_layanan_header::where('id', $d->idlayananheader)
            ->update(['status_pembayaran' => 0]);
        }
        ts_transaksi_kasir_header::where('id', $idpembayaran)
            ->update(['status_pembayaran' => 3]);
        ts_kunjungan::where('kode_kunjungan', $kode_kunjungan)
            ->update(['statuskunjungan' => 1]);

        $data2 = [
            'kode' => 200,
            'message' => 'Pembayaran berhasil diretur !'
        ];
        echo json_encode($data2);
        die;
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
        $data_layanan = db::select('select *,b.id as iddetail from ts_layanan_header a inner join ts_layanan_detail b on a.id = b.id_header where a.kode_kunjungan = ? and a.status_layanan_header = ? and b.status_layanan_detail = ? and a.status_pembayaran = 0 and b.status_order = 1', [$kode_kunjungan, 1, 1]);
        return view('Kasir.tabel_detail_billing', compact([
            'data_layanan','kode_kunjungan'
        ]));
    }
    public function batalsemualayanan(Request $request)
    {
        $kode_kunjungan = $request->kodekunjungan;
        $header = db::select('select * from ts_layanan_header where kode_kunjungan = ? and status_layanan_header = ? and status_pembayaran = ?', [$kode_kunjungan, 1, 0]);
        foreach ($header as $h) {
            $idheader = $h->id;
            ts_layanan_header::where('id', $idheader)->update(['status_layanan_header' => 3]);
            ts_layanan_detail::where('id_header', $idheader)->update(['status_layanan_detail' => 3]);
        }
        $data2 = [
            'kode' => 200,
            'message' => 'Semua layanan berhasil dibatalkan !'
        ];
        echo json_encode($data2);
        die;
    }
    public function returlayanandetail(Request $request)
    {
        $idd = $request->id;
        $detail = db::select('select * from ts_layanan_detail where id = ?',[$idd]);
        $idheader = $detail[0]->id_header;
        $header = db::select('select * from ts_layanan_header where id = ?',[$idheader]);
        ts_layanan_detail::where('id', $idd)->update(['status_layanan_detail' => 3]);
        $total_detail = $detail[0]->total_tarif;
        $total_header = $header[0]->grand_total;
        $new = $total_header - $total_detail;
        if($new == 0){
            $status = 3;
        }else{
            $status = 1;
        }
        ts_layanan_header::where('id', $idheader)->update(['status_layanan_header' => $status,'grand_total' => $new]);
        $data2 = [
            'kode' => 200,
            'message' => 'layanan berhasil dibatalkan !'
        ];
        echo json_encode($data2);
        die;
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
        $data_layanan = db::select('select *,b.id as id_detail from ts_layanan_header a inner join ts_layanan_detail b on a.id = b.id_header where a.kode_kunjungan = ? and b.status_layanan_detail = ? and a.status_layanan_header = ? and b.status_order = 1 and a.status_pembayaran = ?', [$kode_kunjungan, 1, 1, 0]);
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
        $detail = db::select('select * from ts_transaksi_kasir_detail where id_kasir_header = ?', [$id]);
        foreach ($detail as $dd) {
            $id_layanan_header = $dd->idlayananheader;
            ts_layanan_header::where('id', $id_layanan_header)->update(['status_pembayaran' => 1]);
        }
        $dc = db::select('select * from ts_transaksi_kasir_header where id = ?', [$id]);
        $kode_kunjungan = $dc[0]->kode_kunjungan;
        $cek_layanan_header = db::select('select * from ts_layanan_header where kode_kunjungan = ? and status_pembayaran = ? and status_layanan_header = ?', [$kode_kunjungan, 0, 1]);
        if (count($cek_layanan_header) == 0) {
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
    public function get_kasir_retur_header()
    {
        $q = DB::select('SELECT id,RIGHT(kode_retur_header,3) AS kd_max  FROM ts_retur_kasir_header
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
        return 'RET' . str_replace('-', '', $this->get_date()) . $kd;
    }
}
