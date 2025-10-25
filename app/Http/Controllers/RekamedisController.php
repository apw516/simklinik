<?php

namespace App\Http\Controllers;

use App\Models\mt_desa;
use App\Models\mt_kabupaten_kota;
use App\Models\mt_kecamatan;
use App\Models\mt_pasien;
use App\Models\mt_provinsi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class RekamedisController extends Controller
{
    public function indexpendaftaran()
    {
        $menu = 'pendaftaran';
        $mt_provinsi = db::select('select * from mt_provinsi');
        return view('Rekamedis.indexpendaftaran', compact([
            'menu',
            'mt_provinsi'
        ]));
    }
    public function caripasien(Request $request)
    {
        $RM = $request->rm;
        $NAMA = $request->nama;
        $ALAMAT = $request->alamat;
        $NIK = $request->nik;
        $pasien = db::select("CALL WSP_PANGGIL_DATAPASIEN('$RM','$NAMA','$ALAMAT','$NIK')");
        return view('Rekamedis.tabel_pasien',compact([
            'pasien'
        ]));
    }
    public function cariprovinsi(Request $request)
    {
        $term = $request->get('term');
        $results = mt_provinsi::where('name', 'LIKE', '%' . $term . '%')
            ->select('code as value', 'name as label') // Adjust based on your model's columns
            ->get();
        return response()->json($results);
    }
    public function carikabupaten(Request $request)
    {
        $term = $request->get('term');
        $provinsi = $request->get('kodeprovinsi');
        $results = mt_kabupaten_kota::where('name', 'LIKE', '%' . $term . '%')
            ->where('parent_code', '=', $provinsi)
            ->select('code as value', 'name as label') // Adjust based on your model's columns
            ->get();
        return response()->json($results);
    }
    public function carikecamatan(Request $request)
    {
        $term = $request->get('term');
        $kab = $request->get('kodekabupaten');
        $results = mt_kecamatan::where('name', 'LIKE', '%' . $term . '%')
            ->where('parent_code', '=', $kab)
            ->select('code as value', 'name as label') // Adjust based on your model's columns
            ->get();
        return response()->json($results);
    }
    public function caridesa(Request $request)
    {
        $term = $request->get('term');
        $kec = $request->get('kodekecamatan');
        $results = mt_desa::where('name', 'LIKE', '%' . $term . '%')
            ->where('parent_code', '=', $kec)
            ->select('code as value', 'name as label') // Adjust based on your model's columns
            ->get();
        return response()->json($results);
    }
    public function simpandatapasienbaru(Request $request)
    {
        $data = json_decode($_POST['data'], true);
        foreach ($data as $nama) {
            $index =  $nama['name'];
            $value =  $nama['value'];
            $dataSet[$index] = $value;
        }
        $dataSet['tgl_entry'] = $this->get_now();
        $dataSet['pic'] = auth()->user()->id;
        $dataSet['status'] = 1;
        $desa = db::select('select * from mt_desa where code = ?', [$dataSet['kodedesa']]);
        $kode = $desa[0]->parent_code;
        $rm = $this->get_rm($kode);
        $dataSet['no_rm'] = $rm;
        mt_pasien::create($dataSet);
        $data2 = [
            'kode' => 200,
            'message' => 'data berhasil disimpan'
        ];
        echo json_encode($data2);
        die;
    }
    public function get_rm($kode)
    {
        $q = DB::select('SELECT id,no_rm,RIGHT(no_rm,3) AS kd_max  FROM mt_pasien
        WHERE kodekecamatan = ?
        ORDER BY id DESC
        LIMIT 1',[$kode]);
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
        return $kode.$kd;
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
