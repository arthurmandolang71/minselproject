<?php

namespace App\Http\Controllers;

use App\Models\Dpt;
use App\Models\Tps;
use App\Models\Kabkota;
use App\Models\Wilayah;
use App\Models\Kecamatan;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class DptTimController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        //filter per dapil
        $level_caleg = $request->session()->get('level_caleg');

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

        $dpt = Dpt::with(['kabkota_ref', 'kecamatan_ref', 'kelurahandesa_ref'])
            ->orderBy("nama", "asc")
            ->cari(request(['kabkota', 'kecamatan', 'kelurahandesa', 'tps', 'cari_nama']));

        if ($level_caleg == 1) {
            $dpt->with('pendukung', 'pendukung.pendukung_caleg_ri');
        }

        if ($level_caleg == 2) {
            $dpt->with('pendukung', 'pendukung.pendukung_caleg_prov');
        }

        if ($level_caleg == 3) {
            // dd('test');
            $dpt->with('pendukung', 'pendukung.pendukung_caleg_kabkota');
        }


        if ($level_caleg > 1) {
            $kabkota_dapil = $request->session()->get('kabkota_dapil');
            $kabkota_list = Kabkota::whereIn('id', $kabkota_dapil)->get();
        } else {
            $kabkota_list = Kabkota::get();
        }

        return view('tim.dpt.index', [
            'title' => 'Cari Nama DPT 2024',
            'pemilih' => $dpt->cursorPaginate(300)->withQueryString(),
            'total_get' => $dpt->count(),
            'kabkota_list' => $kabkota_list,
            'select_kabkota' => $select_kabkota,
            'select_kecamatan' => $select_kecamatan,
            'select_kelurahandesa' => $select_kelurahandesa,
            'select_tps' => $select_tps,
            'level_caleg' =>  $level_caleg,
            'cari_nama' => $cari_nama,
        ]);
    }

    public function getKecamatan(Request $request, $kabkota_id = 0)
    {
        $level_caleg = $request->session()->get('level_caleg');
        if ($level_caleg == 3) {
            $kecamatan_dapil = $request->session()->get('kecamatan_dapil');
            $data['data'] = Kecamatan::orderby("nama", "asc")
                ->where('parent_id', $kabkota_id)
                ->whereIn('kode_kec', $kecamatan_dapil)
                ->get();
        } else {
            $data['data'] = Kecamatan::orderby("nama", "asc")
                ->where('parent_id', $kabkota_id)
                ->get();
        }

        return response()->json($data);
    }

    public function getKelurahanDesa($kecamatan_id = 0)
    {
        $data['data'] = Wilayah::orderby("nama", "asc")
            ->where('parent_id', $kecamatan_id)
            ->get();
        return response()->json($data);
    }

    public function getTps($wilayah_id = 0)
    {
        $data['data'] = Tps::orderby("nama", "asc")
            ->where('wilayah_id', $wilayah_id)
            ->get();
        return response()->json($data);
    }
}
