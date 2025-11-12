<?php

namespace App\Http\Controllers;

use App\Models\mt_barang;
use App\Models\mt_distributor;
use App\Models\mt_pegawai;
use App\Models\mt_po_detail;
use App\Models\mt_po_header;
use App\Models\mt_sediaan_barang;
use App\Models\mt_tarif;
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
    public function indexstokobat()
    {
        $menu = 'datastokobat';
        $datastok = db::select('select * from mt_sediaan_barang where stok_current > 0 order by id desc');
        return view('Master.indexdatastokobat', compact([
            'menu',
            'datastok'
        ]));
    }
    public function indexpurchaseorder()
    {
        $menu = 'datapo';
        $datapo = db::select('select * from mt_po_header order by id desc');
        return view('Master.indexdatapo', compact([
            'menu',
            'datapo'
        ]));
    }
    public function ambilformpurchaseorder()
    {
        $dis = db::select('select * from mt_distributor');
        return view('Master.formpurchaseorder', compact([
            'dis'
        ]));
    }
    public function ambilFormTerimaPO(Request $request)
    {
        $id = $request->id;
        $detail = db::select('select * ,a.id as idheader,b.id as iddetail from mt_po_header a inner join mt_po_detail b on a.kode_PO = b.kode_PO_header where a.id = ?', [$id]);
        return view('Master.formterimapo', compact([
            'detail'
        ]));
    }
    public function simpandataterimapo(Request $request)
    {
        $data1 = json_decode($_POST['data2'], true);
        $tglterima = $request->tglterima;
        $idheader = $request->idheader;
        foreach ($data1 as $nama) {
            $index =  $nama['name'];
            $value =  $nama['value'];
            $dataSetbarang[$index] = $value;
            $dataSetbarang['tgl_entry'] = $this->get_now();
            if ($index == 'jumlahterima') {
                $arraydist[] = $dataSetbarang;
            }
        }
        $dataheader = [
            'tgl_terima' => $tglterima,
            'status' => 1
        ];
        mt_po_header::where('id', $idheader)
            ->update($dataheader);
        $gth = 0;
        $dataheader = db::select('select * from mt_po_header where id = ?',[$idheader]);
        foreach ($arraydist as $d) {
            $datadetail = [
                'status' => 1,
                'ed' => $d['ed'],
                'kodebatch' => $d['kodebatch'],
                'hargasatuan' => $d['hargasatuan'],
                'grandtotal' => $d['grandtotal'],
                'jumlahterima' => $d['jumlahterima'],
            ];
            $gth = $gth + $d['grandtotal'];
            mt_po_detail::where('id', $d['iddetail'])
                ->update($datadetail);
            $stokkecil = $d['jumlahterima'] * $d['isi'];
            $harga = $d['hargasatuan'] / $d['isi'];
            $data_sediaan = [
                'kode_po' => $dataheader[0]->kode_PO,
                'id_detail_po' => $d['iddetail'],
                'sediaan' => $d['sediaan'],
                'satuan' => $d['satuan'],
                'stok_satuan_besar' => $d['jumlahterima'],
                'stok_satuan_kecil' => $stokkecil,
                'harga_beli_satuan_besar' => $d['hargasatuan'],
                'harga_beli_satuan_kecil' => $harga,
                'ed' => $d['ed'],
                'kodebatch' => $d['kodebatch'],
                'kode_barang' => $d['kodebarang'],
                'nama_barang' => $d['namabarang'],
                'tgl_sediaan' =>  $this->get_date(),
                'tgl_entry' => $this->get_now(),
                'stok_current' => $stokkecil,
                'last_update' =>  $this->get_now(),
            ];
            mt_sediaan_barang::create($data_sediaan);
        }
        $gt = [
            'grandtotal_terima' => $gth
        ];
        mt_po_header::where('id', $idheader)
            ->update($gt);
        $data2 = [
            'kode' => 200,
            'message' => 'data berhasil disimpan !'
        ];
        echo json_encode($data2);
        die;
    }
    public function ambilbarangdistributor(Request $request)
    {
        $mt_barang = db::select('select * from mt_barang where id_distributor = ?', [$request->id]);
        return view('Master.tabel_barang', compact([
            'mt_barang'
        ]));
    }
    public function indexmasterbarang()
    {
        $menu = 'masterbarang';
        $mt_barang = db::select('select * from mt_barang');
        $dis = db::select('select * from mt_distributor');
        return view('Master.indexmasterbarang', compact([
            'menu',
            'mt_barang',
            'dis'
        ]));
    }
    public function indexdatadistributor()
    {
        $menu = 'datadistributor';
        $data = db::select('select * from mt_distributor');
        return view('Master.indexdatadistributor', compact([
            'menu',
            'data'
        ]));
    }
    public function indexdatatarif()
    {
        $menu = 'datatarif';
        $datatarif = db::select('select * from mt_tarif');
        return view('Master.indexdatatarif', compact([
            'menu',
            'datatarif'
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
            'datauser',
            'dataunit'
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
    public function simpanpurchaseorder(Request $request)
    {
        $data1 = json_decode($_POST['data1'], true);
        foreach ($data1 as $nama) {
            $index =  $nama['name'];
            $value =  $nama['value'];
            $dataSetbarang[$index] = $value;
            $dataSetbarang['tgl_entry'] = $this->get_now();
            if ($index == 'jenis') {
                $arraydist[] = $dataSetbarang;
            }
        }
        $data2 = json_decode($_POST['data2'], true);
        foreach ($data2 as $nama) {
            $index =  $nama['name'];
            $value =  $nama['value'];
            $dataSetbarang2[$index] = $value;
            $dataSetbarang2['tgl_entry'] = $this->get_now();
            if ($index == 'jumlah') {
                $arraybarang[] = $dataSetbarang2;
            }
        }
        $kodepo = $this->get_po_header();
        foreach ($arraydist as $d) {
            $dataheader = [
                'kode_PO' => $kodepo,
                'tanggal_po' => $d['tglpo'],
                'tgl_entry' => $d['tgl_entry'],
                'namadistributor' => $d['namadistributor'],
                'iddistributor' => $d['iddistributor'],
                'notelp' => $d['notelp'],
                'alamat' => $d['alamat'],
                'jenis' => $d['jenis'],
            ];
        }
        mt_po_header::create($dataheader);

        foreach ($arraybarang as $dd) {
            $datadetail = [
                'kode_PO_header' => $kodepo,
                'tgl_entry' => $this->get_now(),
                'namabarang' => $dd['namabarang'],
                'idbarang' => $dd['idbarang'],
                'satuan' => $dd['satuan'],
                'isi' => $dd['isi'],
                'sediaan' => $dd['sediaan'],
                'jumlah_po' => $dd['jumlah'],
            ];
            mt_po_detail::create($datadetail);
        }
        $data2 = [
            'kode' => 200,
            'message' => 'data berhasil disimpan'
        ];
        echo json_encode($data2);
        die;
    }
    public function simpanmasterbarang(Request $request)
    {
        $data1 = json_decode($_POST['data1'], true);
        foreach ($data1 as $nama) {
            $index =  $nama['name'];
            $value =  $nama['value'];
            $dataSet[$index] = $value;
        }

        $data2 = json_decode($_POST['data2'], true);
        foreach ($data2 as $nama) {
            $index =  $nama['name'];
            $value =  $nama['value'];
            $dataSetbarang[$index] = $value;
            $dataSetbarang['id_distributor'] = $dataSet['iddist'];
            $dataSetbarang['nama_distributo'] = $dataSet['namadistributor'];
            $dataSetbarang['tgl_entry'] = $this->get_now();
            if ($index == 'keterangan') {
                $arrayindex_brg[] = $dataSetbarang;
            }
        }
        foreach ($arrayindex_brg as $d) {
            mt_barang::create($d);
        }
        $data2 = [
            'kode' => 200,
            'message' => 'data berhasil disimpan'
        ];
        echo json_encode($data2);
        die;
    }
    public function simpandistributor(Request $request)
    {
        $data = json_decode($_POST['data'], true);
        foreach ($data as $nama) {
            $index =  $nama['name'];
            $value =  $nama['value'];
            $dataSet[$index] = $value;
        }
        $dataSet['tgl_entry'] = $this->get_now();
        mt_distributor::create($dataSet);
        $data2 = [
            'kode' => 200,
            'message' => 'data berhasil disimpan'
        ];
        echo json_encode($data2);
        die;
    }
    public function simpantarif(Request $request)
    {
        $data = [
            'nama' => $request->nama,
            'jenis' => $request->jenis,
            'harga' => $request->harga,
        ];
        mt_tarif::create($data);
        $data2 = [
            'kode' => 200,
            'message' => 'data berhasil disimpan'
        ];
        echo json_encode($data2);
        die;
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
    public function get_po_header()
    {
        $q = DB::select('SELECT id,RIGHT(kode_PO,3) AS kd_max  FROM mt_po_header
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
        return 'PO' . str_replace('-', '', $this->get_date()) . $kd;
    }
}
