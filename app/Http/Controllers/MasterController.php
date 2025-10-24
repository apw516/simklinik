<?php

namespace App\Http\Controllers;

use App\Models\mt_pegawai;
use App\Models\mt_unit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use Carbon\Carbon;

class MasterController extends Controller
{
    public function indexdatauser()
    {
        $menu = 'datauser';
        $datauser = db::select('select *,b.nama as nama_unit from user left outer join mt_unit b on user.unit = b.kode_unit');
        return view('Master.indexdatauser', compact([
            'menu',
            'datauser'
        ]));
    }
    public function indexdataunit()
    {
        $menu = 'dataunit';
        $dataunit = db::select('select * from mt_unit');
        return view('Master.indexdataunit', compact([
            'menu',
            'dataunit'
        ]));
    }
    public function indexdatapegawai()
    {
        $menu = 'datapegawai';
        $datapegawai = db::select('select * from mt_pegawai');
        return view('Master.indexdatapegawai', compact([
            'menu',
            'datapegawai'
        ]));
    }
    public function indexdatalokasi()
    {
        $menu = 'datalokasi';
        $mt_provinsi = db::select('select * from mt_provinsi');
        return view('Master.indexdataprovinsi', compact([
            'menu',
            'mt_provinsi'
        ]));
    }
    public function ambildetailuser(Request $request)
    {
        $id = $request->id;
        $datauser = db::select('select * from user where id = ?', [$id]);
        $dataunit = db::select('select * from mt_unit');
        return view('Master.form_edit_user', compact([
            'datauser','dataunit'
        ]));
    }
    public function ambildetailpegawai(Request $request)
    {
        $id = $request->id;
        $datapegawai = db::select('select * from mt_pegawai where id = ?', [$id]);
        return view('Master.form_edit_pegawai', compact([
            'datapegawai'
        ]));
    }
    public function ambildetailunit(Request $request)
    {
        $id = $request->id;
        $dataunit = db::select('select * from mt_unit where kode_unit = ?', [$id]);
        return view('Master.form_edit_unit', compact([
            'dataunit'
        ]));
    }
    public function simpanunit(Request $request)
    {
        $data = [
            'nama' => trim(strtoupper($request->nama)),
            'jenis' => $request->jenis,
            'status' => 1,
            'tgl_entry' => $this->get_now(),
        ];
        mt_unit::create($data);
        $data2 = [
            'kode' => 200,
            'message' => 'data berhasil disimpan'
        ];
        echo json_encode($data2);
        die;
    }
    public function simpanpegawai(Request $request)
    {
        $data = [
            'NIK' => $request->nikpegawai,
            'nama' => $request->namalengkap,
            'kontak' => $request->nomorkontak,
            'jabatan' => $request->jabatan,
            'tgl_entry' => $this->get_now(),
            'status' => 1
        ];        
        mt_pegawai::create($data);
        $data2 = [
            'kode' => 200,
            'message' => 'data berhasil disimpan'
        ];
        echo json_encode($data2);
        die;
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
