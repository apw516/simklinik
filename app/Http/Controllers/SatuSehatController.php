<?php

namespace App\Http\Controllers;

use App\Models\mt_desa;
use App\Models\mt_kabupaten_kota;
use App\Models\mt_kecamatan;
use App\Models\mt_provinsi;
use Illuminate\Http\Request;
use App\Models\satusehat;
use Illuminate\Support\Facades\DB;

class SatuSehatController extends Controller
{
    public function search_pasien(Request $request)
    {
        $v = new satusehat();
        $result = $v->patient_search_nik('3209330506940003');
    }
    public function get_provinsi(Request $request)
    {
        $v = new satusehat();
        $limit = 5;
        for ($i=1; $i < $limit; $i++) { 
            $result = $v->get_prov($i);
            foreach($result->data as $d){
                $dt = [
                    'code' => $d->code,
                    'parent_code' => $d->parent_code,
                    'bps_code' => $d->bps_code,
                    'name' => $d->name
                ];
                mt_provinsi::create($dt);
            }
        }
    }
    public function downloadkabupaten(Request $request)
    {
        $id = $request->idprov;
        $v = new satusehat();
        $limit = 5;
        $result = $v->get_kab($id);
        $kab=[];
        foreach($result->data as $d){
            $dt = [
                'code' => $d->code,
                'parent_code' => $d->parent_code,
                'bps_code' => $d->bps_code,
                'name' => $d->name
            ];    
            $kab[] = $dt;   
        }
        foreach($kab as $k){
            $cek = db::select('select * from mt_kabupaten_kota where code = ?',[$k['code']]);
            if(count($cek) == 0){
                mt_kabupaten_kota::create($k);
            }
        } 
        $data = [
            'code' => 200,
            'message' => 'SUKSES'
        ];
        return json_encode($data);
    }
    public function downloadkecamatan(Request $request)
    {
        $id = $request->kodekabupaten;
        $v = new satusehat();
        $limit = 5;
        $result = $v->get_kec($id);
        $kec=[];
        foreach($result->data as $d){
            $dt = [
                'code' => $d->code,
                'parent_code' => $d->parent_code,
                'bps_code' => $d->bps_code,
                'name' => $d->name
            ];    
            $kec[] = $dt;   
        }
        foreach($kec as $k){
            $cek = db::select('select * from mt_kecamatan where code = ?',[$k['code']]);
            if(count($cek) == 0){
                mt_kecamatan::create($k);
            }
        } 
        $data = [
            'code' => 200,
            'message' => 'SUKSES'
        ];
        return json_encode($data);
    }
    public function downloaddesa(Request $request)
    {
        $id = $request->kodekecamatan;
        $v = new satusehat();
        $limit = 5;
        $result = $v->get_desa($id);
        $desa=[];
        foreach($result->data as $d){
            $dt = [
                'code' => $d->code,
                'parent_code' => $d->parent_code,
                'bps_code' => $d->bps_code,
                'name' => $d->name
            ];    
            $desa[] = $dt;   
        }
        foreach($desa as $k){
            $cek = db::select('select * from mt_desa where code = ?',[$k['code']]);
            if(count($cek) == 0){
                mt_desa::create($k);
            }
        } 
        $data = [
            'code' => 200,
            'message' => 'SUKSES'
        ];
        return json_encode($data);
    }
    public function ambilformaddkecamatan(Request $request)
    {
        $id = $request->id;
        $kabupaten = db::select('select * from mt_kabupaten_kota where parent_code =?',[$id]);
        return view('Master.form_add_kecamatan',compact([
            'kabupaten'
        ]));
    }
    public function ambil_form_desa(Request $request)
    {
        $id = $request->id;
        $kabupaten = db::select('select * from mt_kabupaten_kota where parent_code =?',[$id]);
        return view('Master.form_add_desa_1',compact([
            'kabupaten'
        ]));
    }
    public function ambil_kecamatan(Request $request)
    {
        $id = $request->idkab;
        $kecamatan = db::select('select * from mt_kecamatan where parent_code =?',[$id]);
        return view('Master.form_add_desa_2',compact([
            'kecamatan'
        ]));
    }
}
