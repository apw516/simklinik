<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RekamedisController extends Controller
{
    public function indexpendaftaran()
    {
        $menu = 'pendaftaran';
        $mt_provinsi = db::select('select * from mt_provinsi');
        return view('Rekamedis.indexpendaftaran', compact([
            'menu','mt_provinsi'
        ]));
    }
    public function ambil_kabupaten_rekamedis(Request $request)
    {
        $kab = db::select('select * from mt_kabupaten_kota where parent_code = ?',[$request->prov]);
        return view('Rekamedis.list_kab', compact([
            'kab'
        ]));
    }
    public function ambil_kecamatan_rekamedis(Request $request)
    {
        $kec= db::select('select * from mt_kecamatan where parent_code = ?',[$request->kab]);
        return view('Rekamedis.list_kec', compact([
            'kec'
        ]));
    }
    public function ambil_desa_rekamedis(Request $request)
    {
        $desa= db::select('select * from mt_desa where parent_code = ?',[$request->kec]);
        return view('Rekamedis.list_desa', compact([
            'desa'
        ]));
    }
    public function simpandatapasienbaru(Request $request)
    {
        $data = json_decode($_POST['data'], true);
        foreach ($data as $nama) {
            $index =  $nama['name'];
            $value =  $nama['value'];
            $dataSet[$index] = $value;
        }
        dd($dataSet);
    }
}
