<?php

namespace App\Http\Controllers;

use App\Models\icd10;
use App\Models\ts_kunjungan;
use App\Models\ts_layanan_detail;
use App\Models\ts_layanan_header;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DokterController extends MasterController
{
    public function indexdatakunjungandokter()
    {
        $menu = 'datakunjungan';
        $date = $this->get_date();
        return view('Dokter.indexdatakunjungan', compact([
            'menu','date'
        ]));
    }
    public function caridiagnosa(Request $request)
    {
        $term = $request->get('term');
        $results = icd10::where('nama', 'LIKE', '%' . $term . '%')
            ->select('diag as value', 'nama as label') // Adjust based on your model's columns
            ->get();
        return response()->json($results);
    }
    public function caripasiendokter(Request $request){
        $tglawal = $request->tglawal;
        $tglakhir = $request->tglakhir;
        $datakunjungan = db::select('select * from ts_kunjungan a 
        inner join mt_pasien b on a.no_rm = b.no_rm
        where a.statuskunjungan != 3 and a.tanggalkunjungan between ? and  ?',[$tglawal,$tglakhir]);
        return view('Dokter.tabel_kunjungan',compact([
            'datakunjungan'
        ]));
    }
    public function ambildetailpasiendokter(Request $request){
        $rm = $request->rm;
        $kode_kunjungan = $request->kodekunjungan;
        $mt_pasien = db::select('select * from mt_pasien where no_rm = ?', [$rm]);
        $riwayat = db::select('select * from ts_kunjungan where no_rm = ? and statuskunjungan != 3 order by kode_kunjungan desc', [$rm]);
        $kunjungan = db::select('select * from ts_kunjungan where kode_kunjungan = ?', [$kode_kunjungan]);
        $date = $this->get_date();
        $mt_tarif = db::select('select * from mt_tarif where jenis != ?',['RI']);
        return view('Dokter.form_erm_dokter',compact([
            'mt_pasien','riwayat','kunjungan','kode_kunjungan','mt_tarif'
        ]));
    }
    public function simpanpemeriksaandokter(Request $request){
        $data = json_decode($_POST['data'], true);
        $data2 = json_decode($_POST['data2'], true);
        foreach ($data as $nama) {
            $index =  $nama['name'];
            $value =  $nama['value'];
            $dataSet[$index] = $value;
        }
         foreach ($data2 as $nama2) {
            $index2 = $nama2['name'];
            $value2 = $nama2['value'];
            $dataSet2[$index2] = $value2;
            if ($index2 == 'harga') {
                $arraytarif[] = $dataSet2;
            }
        }
        // dd($arraytarif);
        if(count($data2) > 0){
            $kode_header = $this->get_layanan_header($id = 'RJ');
            $layanan_header = [
                'kode_kunjungan' => $request->kode_kunjungan,
                'kode_layanan_header' => $kode_header,
                'status_layanan_header' => '1',
                'status_pembayaran' => 0,
                'tgl_entry' => $this->get_now(),
                'pic' => auth()->user()->id
            ];
            $header = ts_layanan_header::create($layanan_header);
            $total_header = 0;
            foreach($arraytarif as $r){
                $layanan_detail = [
                    'id_header' => $header->id,
                    'idlayanan' => $r['idtarif'],
                    'nama_layanan' => $r['namatarif'],
                    'tarif' => $r['harga2'],
                    'jenis' => 'TARIF LAYANAN',
                    'status_layanan_detail' => '1',
                    'total_tarif' => $r['harga2'],
                ];
                ts_layanan_detail::create($layanan_detail);
                $total_header = $total_header + $r['harga2'];
            }
            ts_layanan_header::where('id', $header->id)
            ->update(['grand_total' => $total_header]);
        }
        $dataSet['status_pemeriksaan'] = 1;
        ts_kunjungan::where('kode_kunjungan', $request->kode_kunjungan)
            ->update($dataSet);
        $data2 = [
            'kode' => 200,
            'message' => 'Hasil pemeriksaan berhasil disimpan !'
        ];
        echo json_encode($data2);
        die;
    }
    public function ambilriwayatbilling(Request $request)
    {
        $kode_kunjungan = $request->kode_kunjungan;
        $ts_layanan = db::select('select *,b.id as iddetail from ts_layanan_header a inner join ts_layanan_detail b on a.id = b.id_header where a.kode_kunjungan = ? and b.status_layanan_detail = 1',[$kode_kunjungan]);
        return view('Dokter.riwayat_billing',compact([
            'ts_layanan'
        ]));
    }
    public function get_layanan_header($kode)
    {
        $q = DB::select('SELECT id,RIGHT(kode_layanan_header,3) AS kd_max  FROM ts_layanan_header
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
        return $kode .str_replace('-','',$this->get_date()). $kd;
    }
}
