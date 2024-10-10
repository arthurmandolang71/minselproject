<?php

namespace App\Http\Controllers;

use App\Models\Dpt;
use App\Models\Kabkota;
use App\Models\Wilayah;
use App\Models\RefAgama;
use App\Models\Kecamatan;
use App\Models\RefPekerjaan;
use App\Models\TimReferensi;
use Illuminate\Http\Request;
use App\Models\RefPendidikan;
use App\Models\CalegPendukung;
use App\Models\CalegPendukungRi;
use App\Models\CalegPendukungProv;
use App\Models\KlasifikasiBantuan;
use Illuminate\Routing\Controller;
use App\Models\KlasifikasiPendukung;
use App\Models\CalegPendukungKabkota;
use Illuminate\Support\Facades\Storage;

class PendukungTimController extends Controller
{
    public function index(Request $request)
    {
        //filter per dapil
        $level_caleg = $request->session()->get('level_caleg');
        $user_id = $request->session()->get('user_id');
        $relawan_id = $request->session()->get('relawan_id');

        if (request('kabkota') != '') {
            $get_kabkota = Kabkota::firstWhere('id', request('kabkota'));
            $select_kabkota = [
                'id' => $get_kabkota->id,
                'nama' => $get_kabkota->nama,
            ];
        } else {
            $select_kabkota = NULL;
        }

        if (request('kecamatan') != '') {
            $get_kecamatan = Kecamatan::firstWhere('id', request('kecamatan'));
            $select_kecamatan = [
                'id' => $get_kecamatan->id,
                'nama' => $get_kecamatan->nama,
            ];
        } else {
            $select_kecamatan = NULL;
        }

        if (request('kelurahandesa') != '') {
            $get_kelurahandesa = Wilayah::firstWhere('id', request('kelurahandesa'));
            $select_kelurahandesa = [
                'id' => $get_kelurahandesa->id,
                'nama' => $get_kelurahandesa->nama,
            ];
        } else {
            $select_kelurahandesa = NULL;
        }

        if (request('bantuan') != '') {
            $get_bantuan = KlasifikasiBantuan::firstWhere('id', request('bantuan'));
            $select_bantuan = [
                'id' => $get_bantuan->id,
                'nama' => $get_bantuan->nama,
            ];
        } else {
            $select_bantuan = NULL;
        }

        if (request('klasifikasi') != '') {
            $get_klasifikasi = KlasifikasiPendukung::firstWhere('id', request('klasifikasi'));
            $select_klasifikasi = [
                'id' => $get_klasifikasi->id,
                'nama' => $get_klasifikasi->nama,
            ];
        } else {
            $select_klasifikasi = NULL;
        }

        if (request('tps') != '') {
            $string_tps = sprintf('%03d', request('tps'));
            $select_tps = $string_tps;
        } else {
            $select_tps = NULL;
        }

        if (request('cari_nama') != '') {
            $cari_nama = request('cari_nama');
        } else {
            $cari_nama = NULL;
        }

        if ($level_caleg == 1) {
            $pendukung = CalegPendukungRi::with('klasifikasi_ref', 'bantuan_ref', 'relawan_ref', 'pendukung_ref', 'pendukung_ref.kabkota_ref', 'pendukung_ref.kecamatan_ref', 'pendukung_ref.kelurahandesa_ref')
                ->orderBy("nama", "asc")
                ->cari(request(['kabkota', 'kecamatan', 'kelurahandesa', 'tps', 'bantuan ', 'referensi', 'klasifikasi', 'cari_nama']))
                ->where('referensi_id', $relawan_id);
        }

        if ($level_caleg == 2) {
            $pendukung = CalegPendukungProv::with('klasifikasi_ref', 'bantuan_ref', 'relawan_ref', 'pendukung_ref', 'pendukung_ref.kabkota_ref', 'pendukung_ref.kecamatan_ref', 'pendukung_ref.kelurahandesa_ref')
                ->orderBy("nama", "asc")
                ->cari(request(['kabkota', 'kecamatan', 'kelurahandesa', 'tps', 'bantuan ', 'referensi', 'klasifikasi', 'cari_nama']))
                ->where('referensi_id', $relawan_id);
        }

        if ($level_caleg == 3) {
            $pendukung = CalegPendukungKabkota::with('klasifikasi_ref', 'bantuan_ref', 'relawan_ref', 'pendukung_ref', 'pendukung_ref.kabkota_ref', 'pendukung_ref.kecamatan_ref', 'pendukung_ref.kelurahandesa_ref')
                // ->orderBy("pendukung_ref.nama", "asc")
                ->cari(request(['kabkota', 'kecamatan', 'kelurahandesa', 'tps', 'bantuan ', 'referensi', 'klasifikasi', 'cari_nama']))
                ->where('referensi_id', $relawan_id);
        }

        if ($level_caleg > 1) {
            $kabkota_dapil = $request->session()->get('kabkota_dapil');
            $kabkota_list = Kabkota::whereIn('id', $kabkota_dapil)->get();
        } else {
            $kabkota_list = Kabkota::get();
        }

        $referensi_list = TimReferensi::where('user_id_caleg', $user_id)->get();
        $bantuan_list = KlasifikasiBantuan::where('user_id', $user_id)->get();
        $klasifikasi_list = KlasifikasiPendukung::where('user_id', $user_id)->get();

        // dd($referensi_list);

        return view('tim.pendukung.index', [
            'title' => 'Data Pendukung',
            'pendukung' => $pendukung->orderBy('kk', 'asc')->cursorPaginate(300)->withQueryString(),
            'total_get' => $pendukung->count(),
            'kabkota_list' => $kabkota_list,
            'referensi_list' => $referensi_list,
            'klasifikasi_list' => $klasifikasi_list,
            'bantuan_list' => $bantuan_list,
            'select_kabkota' => $select_kabkota,
            'select_kecamatan' => $select_kecamatan,
            'select_kelurahandesa' => $select_kelurahandesa,
            'select_bantuan' => $select_bantuan,
            'select_klasifikasi' => $select_klasifikasi,
            'select_tps' => $select_tps,
            'cari_nama' => $cari_nama,
        ]);
    }

    public function create(Request $request, $id_dpt, $id_status)
    {

        // 1 sudah terinput di pendukung , 2 belum terinput di pendukung
        $agama = RefAgama::all();
        $pekerjaan = RefPekerjaan::all();
        $pendidikan = RefPendidikan::all();

        $user_id = $request->session()->get('user_id_caleg');
        $bantuan = KlasifikasiBantuan::where('user_id', $user_id)->get();
        $klasifikasi = KlasifikasiPendukung::where('user_id', $user_id)->get();

        // dd($user_id);

        if ($id_status == 1) {
            $level_caleg = $request->session()->get('level_caleg');
            if ($level_caleg == 1) {
                $dpt = CalegPendukung::with(['pendukung_caleg_ri'])->where('dpt', $id_dpt)->first();
            } elseif ($level_caleg == 2) {
                $dpt = CalegPendukung::with(['pendukung_caleg_prov'])->where('dpt', $id_dpt)->first();
            } elseif ($level_caleg == 3) {
                $dpt = CalegPendukung::with(['pendukung_caleg_kabkota'])->where('dpt', $id_dpt)->first();
                // dd($id_dpt);
            }
        }

        if ($id_status == 2) {
            $dpt = Dpt::where('id', $id_dpt)->first();
        }

        $url_direct = url()->previous();

        $level_caleg = session()->get('level_caleg');
        if ($level_caleg == 3) {
            $view = 'tim.pendukung.form_caleg_kabkota';
        } elseif ($level_caleg == 2) {
            $view = 'tim.pendukung.form_caleg_prov';
        } elseif ($level_caleg == 1) {
            $view = 'tim.pendukung.form_caleg_ri';
        }

        return view($view, [
            'title' => 'Input Pendukung',
            'agama' => $agama,
            'dpt' => $dpt,
            'status' => $id_status,
            'pendidikan' => $pendidikan,
            'pekerjaan' => $pekerjaan,
            'bantuan' => $bantuan,
            'klasifikasi' => $klasifikasi,
            'jenis_kelamin' => ['L', 'P'],
            'status_perkawinan' => ['Belum Kawin', 'Kawin', 'Cerai Hidup', 'Cerai Mati'],
            'status_keluarga' => ['SUAMI', 'ISTRI', 'ANAK/CUCU', 'SAUDARA/LAINYA'],
            'url_direct' => $url_direct
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    /**
     * tambah pendukung dulu
     * tambah pendukung kabkota/prov/ri
     */
    public function store(Request $request)
    {
        $relawan_id = $request->session()->get('relawan_id');

        if ($request->file('foto')) {
            $validasi['foto'] = ['image', 'file', 'mimes:jpeg,png,jpg', 'max:5024'];
        } else {
            $validasi['foto'] = [];
        }

        $request->validate($validasi);

        if ($request->file('foto')) {
            $file = $request->file('foto');
            $path = Storage::put('foto_pendukung_teman_caleg', $file);
            Storage::setVisibility($path, 'public');
            $pendukung_caleg['foto'] = Storage::url($path);
        }

        $status = $request->status;
        $url = $request->url_direct;

        // dd($request->dpt_id);

        $dpt = Dpt::where('id', $request->dpt_id)->first();
        $pendukung['dpt'] = $dpt->id;
        $pendukung['nama'] = $dpt->nama;
        $pendukung['kabkota'] = $dpt->kabkota;
        $pendukung['kecamatan'] = $dpt->kecamatan;
        $pendukung['kelurahan_desa'] = $dpt->kelurahan_desa;
        $pendukung['rt'] = $dpt->rt;
        $pendukung['rw'] = $dpt->rw;
        $pendukung['tps'] = $dpt->tps;
        $pendukung['usia'] = $dpt->usia;
        $pendukung['jenis_kelamin'] = $dpt->jenis_kelamin;

        $pendukung_caleg['ktp'] = $request->ktp;
        $pendukung_caleg['tempat_lahir'] = $request->tempat_lahir;
        $pendukung_caleg['tanggal_lahir'] = $request->tanggal_lahir;
        $pendukung_caleg['agama'] = $request->agama;
        $pendukung_caleg['pekerjaan'] = $request->pekerjaan;
        $pendukung_caleg['alamat_detail'] = $request->alamat_detail;
        $pendukung_caleg['no_hp'] = $request->no_hp;
        $pendukung_caleg['no_wa'] = $request->no_wa;
        $pendukung_caleg['status_perkawinan'] = $request->status_perkawinan;
        $pendukung_caleg['referensi_id'] = $relawan_id;
        $pendukung_caleg['klasifikasi_id'] = $request->klasifikasi_id;
        $pendukung_caleg['klasifikasi_bantuan_id'] = $request->klasifikasi_bantuan_id;
        $pendukung_caleg['strtime_tanggal_lahir'] = strtotime($pendukung_caleg['tanggal_lahir']);
        $pendukung_caleg['long'] = $request->long;
        $pendukung_caleg['lat'] = $request->lat;
        $pendukung_caleg['dpt'] = $pendukung['dpt'];
        $pendukung_caleg['kk'] = $request->kk;
        $pendukung_caleg['status_keluarga'] = $request->status_keluarga;

        $caleg_id = $request->session()->get('caleg_id');
        $pendukung_caleg['celeg_id'] = $caleg_id;

        $level_caleg = $request->session()->get('level_caleg');
        $dapil_id = $request->session()->get('dapil_id');
        // dd($pendukung_caleg);
        if ($level_caleg == 1) {
            // $pendukung['dapil_ri'] = $dapil_id;
            $cek_sudah_input = CalegPendukungRi::where('dpt', $request->dpt_id)->where('celeg_id', $caleg_id)->first();
            if ($cek_sudah_input) {
                CalegPendukungRi::where('id', $cek_sudah_input->id)->update($pendukung_caleg);
            } else {
                CalegPendukungRi::create($pendukung_caleg);
            }
        } elseif ($level_caleg == 2) {

            // $pendukung['dapil_prov'] = $dapil_id;
            $cek_sudah_input = CalegPendukungProv::where('dpt', $request->dpt_id)->where('celeg_id', $caleg_id)->first();
            if ($cek_sudah_input) {
                CalegPendukungProv::where('id', $cek_sudah_input->id)->update($pendukung_caleg);
            } else {
                CalegPendukungProv::create($pendukung_caleg);
            }
        } elseif ($level_caleg == 3) {
            // $pendukung['dapil_kabkota'] = $dapil_id;
            $cek_sudah_input = CalegPendukungKabkota::where('dpt', $request->dpt_id)->where('celeg_id', $caleg_id)->first();
            if ($cek_sudah_input) {
                CalegPendukungKabkota::where('id', $cek_sudah_input->id)->update($pendukung_caleg);
            } else {
                CalegPendukungKabkota::create($pendukung_caleg);
            }
        }

        // dd($data);
        if ($status == 2) {
            CalegPendukung::create($pendukung);
        }

        // return "berhasil";

        return redirect("$url")->with('pesan', 'Pendukung Berhasil di tambahkan');
    }
}
