<?php

namespace App\Http\Controllers;

use App\Models\mt_desa;
use App\Models\mt_kabupaten_kota;
use App\Models\mt_kecamatan;
use App\Models\mt_pasien;
use App\Models\mt_pegawai;
use App\Models\mt_provinsi;
use App\Models\mt_unit;
use App\Models\ts_kunjungan;
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
        return view('Rekamedis.tabel_pasien', compact([
            'pasien'
        ]));
    }
    public function cariunit(Request $request)
    {
        $term = $request->get('term');
        $results = mt_unit::where('nama', 'LIKE', '%' . $term . '%')
            ->select('kode_unit as value', 'nama as label') // Adjust based on your model's columns
            ->get();
        return response()->json($results);
    }
    public function caridokter(Request $request)
    {
        $term = $request->get('term');
        $results = mt_pegawai::where('nama', 'LIKE', '%' . $term . '%')
            ->where('jabatan', '=', 'dokter')
            ->select('id as value', 'nama as label') // Adjust based on your model's columns
            ->get();
        return response()->json($results);
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
    public function simpanpendaftaranpasien(Request $request)
    {
        $data = json_decode($_POST['data'], true);
        foreach ($data as $nama) {
            $index =  $nama['name'];
            $value =  $nama['value'];
            $dataSet[$index] = $value;
        }
        if ($dataSet['kodeunit'] == '') {
            $data2 = [
                'kode' => 500,
                'message' => 'Unit belum dipilih ...'
            ];
            echo json_encode($data2);
            die;
        }
        if ($dataSet['kodedokter'] == '') {
            $data2 = [
                'kode' => 500,
                'message' => 'Dokter belum dipilih ...'
            ];
            echo json_encode($data2);
            die;
        }
        if ($dataSet['keluhanpasien'] == '') {
            $data2 = [
                'kode' => 500,
                'message' => 'keluhan pasien belum diisi ...'
            ];
            echo json_encode($data2);
            die;
        }
        $dataSet['pic'] = auth()->user()->id;
        $cek2 = db::select('select * from ts_kunjungan where no_rm = ? and statuskunjungan = 1 order by kode_kunjungan desc', [$dataSet['no_rm']]);
        if (count($cek2) > 0) {
            $data2 = [
                'kode' => 500,
                'message' => 'Pendaftaran gagal, kujungan pasien belum ditutup !'
            ];
            echo json_encode($data2);
            die;
        }
        $cek = db::select('select * from ts_kunjungan where no_rm = ? and statuskunjungan != 3 order by kode_kunjungan desc', [$dataSet['no_rm']]);
        if (count($cek) == 0) {
            $counter = 1;
        } else {
            $counter = $cek[0]->counter + 1;
        }

        $dataSet['counter'] = $counter;
        $dataSet['tglentry'] = $this->get_now();
        $dataSet['statuskunjungan'] = 1;
        ts_kunjungan::create($dataSet);
        $data2 = [
            'kode' => 200,
            'message' => 'Data Pendaftaran Berhasil disimpan ...'
        ];
        echo json_encode($data2);
        die;
    }
    public function ambilriwayatkunjungan(Request $request)
    {
        $rm = $request->rm;
        $riwayat = db::select('select * from ts_kunjungan where no_rm = ? and statuskunjungan != 3 order by kode_kunjungan desc', [$rm]);
        return view('Rekamedis.tabel_riwayat_kunjungan', compact([
            'riwayat'
        ]));
    }
    public function riwayatpendaftaran(Request $request)
    {
        $riwayat = db::select('select * from ts_kunjungan inner join mt_pasien b on ts_kunjungan.no_rm = b.no_rm where tanggalkunjungan = ? and statuskunjungan != 3 order by kode_kunjungan asc', [$this->get_date()]);
        return view('Rekamedis.list_tabel_riwayat_kunjungan', compact([
            'riwayat'
        ]));
    }
    public function batalkunjungan(Request $request)
    {
        $kode_kunjungan = $request->kodekunjungan;
        $status = $request->status;
        if($status == 2){
            $m = 'Tutup';
        }else{
            $m = 'Batalkan';
        }
        ts_kunjungan::where('kode_kunjungan', $kode_kunjungan)
            ->update(['statuskunjungan' => $status]);
        $data2 = [
            'kode' => 200,
            'message' => 'data kunjungan berhasil di '. $m .' !'
        ];
        echo json_encode($data2);
        die;
    }
    public function ambilformpendaftaran(Request $request)
    {
        $mt_pasien = db::select('select * from mt_pasien where no_rm = ?', [$request->rm]);
        $date = $this->get_date();
        return view('Rekamedis.form_pendaftaran', compact([
            'mt_pasien',
            'date'
        ]));
    }
    public function get_rm($kode)
    {
        $q = DB::select('SELECT id,no_rm,RIGHT(no_rm,3) AS kd_max  FROM mt_pasien
        WHERE kodekecamatan = ?
        ORDER BY id DESC
        LIMIT 1', [$kode]);
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
        return $kode . $kd;
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
