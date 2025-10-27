<?php

namespace App\Http\Controllers;

use App\Models\icd10;
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
        return view('Dokter.form_erm_dokter',compact([
            'mt_pasien','riwayat','kunjungan'
        ]));
    }
    public function simpanpemeriksaandokter(Request $request){
        $data = json_decode($_POST['data'], true);
        foreach ($data as $nama) {
            $index =  $nama['name'];
            $value =  $nama['value'];
            $dataSet[$index] = $value;
        }
        dd($dataSet);
    }
}
