<?php

namespace App\Http\Controllers;

use App\Models\mt_sediaan_barang;
use App\Models\ts_layanan_detail;
use App\Models\ts_transaksi_obat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use Carbon\Carbon;

class FarmasiController extends Controller
{
    public function indexdataorder()
    {
        $menu = 'dataorderobat';
        $dataorder =  db::select('select *,b.tgl_entry as tglorder,b.id as idheader from ts_kunjungan a inner join ts_layanan_header b on a.kode_kunjungan = b.kode_kunjungan inner join mt_pasien c on a.no_rm = c.no_rm where b.status_layanan_header = ? and jenis = ? order by b.id desc', ['1', 'OBAT']);
        return view('Farmasi.indexdataorderobat', compact([
            'menu',
            'dataorder'
        ]));
    }
    public function ambildataorder(Request $request)
    {
        $idheader = $request->idheader;
        $detail = db::select('select *,a.id as iddetail from ts_layanan_detail a inner join mt_sediaan_barang b on a.idlayanan = b.id where a.id_header = ?', [$idheader]);
        return view('Farmasi.tabel_order', compact([
            'detail'
        ]));
    }
    public function ambildetailbarangorder(Request $request)
    {
        $detail = db::select('select *,a.id as iddetail from ts_layanan_detail a inner join mt_sediaan_barang b on a.idlayanan = b.id where a.id = ?', [$request->iddetail]);
        return view('Farmasi.formeditbarangorder', compact([
            'detail'
        ]));
    }
    public function simpaneditorderan(Request $request)
    {
        $data = json_decode($_POST['data'], true);
        foreach ($data as $nama) {
            $index =  $nama['name'];
            $value =  $nama['value'];
            $dataSet[$index] = $value;
        }
        $dataedit = [
            'aturan_pakai' => $dataSet['aturanpakai'],
            'jumlah_layanan' => $dataSet['qtyorder'],
            'jenistarif' => $dataSet['jenistarif'],
            'status_layanan_detail' => $dataSet['statusorder']
        ];
          ts_layanan_detail::where('id', $dataSet['iddetail'])
                ->update($dataedit);
                     $data2 = [
            'kode' => 200,
            'message' => 'Data order berhasil diubah !'
        ];
        echo json_encode($data2);
        die;
        
    }
    public function terimaorderanobat(Request $request)
    {
        $data3 = json_decode($_POST['data3'], true);
        $idheader = $request->idheader;
        foreach ($data3 as $nama3) {
            $index3 = $nama3['name'];
            $value3 = $nama3['value'];
            $dataSet3[$index3] = $value3;
            if ($index3 == 'aturanpakai') {
                $arrayobat[] = $dataSet3;
            }
        }
        if (count($data3) > 0) {
        }
        $detail = db::select('select * from ts_layanan_detail where id_header = ? and status_layanan_detail = 1 and status_order = 0', [$idheader]);
        $header = db::select('select * from ts_layanan_header where id = ?', [$idheader]);
        foreach ($detail as $d) {
            $stok_sediaan = db::select('select * from mt_sediaan_barang where id = ?', [$d->idlayanan]);
            $data_transaksi = [
                'id_dokumen_header' => $d->id_header,
                'id_dokumen_detail' => $d->id,
                'id_stok_sediaan' => $d->idlayanan,
                'kode_kunjugan' => $header[0]->kode_kunjungan,
                'nama_barang' => $d->nama_layanan,
                'tarif' => $d->tarif,
                'stok_out' => $d->jumlah_layanan,
                'stok_last' => $stok_sediaan[0]->stok_current,
                'stok_current' => $stok_sediaan[0]->stok_current - $d->jumlah_layanan,
                'tgl_transaksi' => $this->get_now()
            ];
            ts_layanan_detail::where('id',$d->id)->update(['status_order' => 1]);
            ts_transaksi_obat::create($data_transaksi);
            mt_sediaan_barang::where('id', $d->idlayanan)
                ->update(['stok_current' =>  $stok_sediaan[0]->stok_current - $d->jumlah_layanan, 'last_update' => $this->get_now()]);
        }
        $data2 = [
            'kode' => 200,
            'message' => 'Data order berhasil diterima !'
        ];
        echo json_encode($data2);
        die;
    }
    public function ambildetailorder(request $request)
    {
        $idheader = $request->idheader;
        $mt_stok = db::select('select * from mt_sediaan_barang where stok_current != ?', [0]);
        return view('Farmasi.detail_order', compact([
            'idheader',
            'mt_stok'
        ]));
    }
    public function get_now()
    {
        $dt = Carbon::now()->timezone('Asia/Jakarta');
        $date = $dt->toDateString();
        $time = $dt->toTimeString();
        $now = $date . ' ' . $time;
        return $now;
    }
    public function get_date()
    {
        $dt = Carbon::now()->timezone('Asia/Jakarta');
        $date = $dt->toDateString();
        $now = $date;
        return $now;
    }
}
