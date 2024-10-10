<?php

namespace App\Http\Controllers;

use App\Models\CalegKabkota;
use App\Models\CalegPendukungKabkota;
use App\Models\CalegPendukungProv;
use App\Models\CalegPendukungRi;
use App\Models\CalegProv;
use App\Models\CalegRi;
use App\Models\DapilKabkota;
use App\Models\DapilProv;
use App\Models\DapilRi;
use App\Models\KlasifikasiBantuan;
use App\Models\KlasifikasiPendukung;
use App\Models\TimReferensi;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;


class DashboardCaleg extends Controller
{
    //
    public function index(Request $request)
    {

        $level_caleg = $request->session()->get('level_caleg');
        $dapil_id = $request->session()->get('dapil_id');
        $user_id = $request->session()->get('user_id');
        $caleg_id = $request->session()->get('caleg_id');

        $bantuan = KlasifikasiBantuan::where('user_id', $user_id)->get();
        $referensi = TimReferensi::where('user_id_caleg', $user_id);
        $klasifikasi = KlasifikasiPendukung::where('user_id', $user_id)->get();

        if ($level_caleg == 1) {
            $dapil = DapilRi::where('id', $dapil_id)->first();
            $caleg = CalegRi::where('user_id', $user_id)->first();
        } elseif ($level_caleg == 2) {
            $dapil = DapilProv::where('id', $dapil_id)->first();
            $caleg = CalegProv::where('user_id', $user_id)->first();
        } elseif ($level_caleg == 3) {
            $dapil = DapilKabkota::where('id', $dapil_id)->first();
            $caleg = CalegKabkota::where('user_id', $user_id)->first();
        }

        // dd($caleg);

        if ($level_caleg == 1) {
            $total_pendukung = CalegPendukungRi::where('celeg_id', $caleg_id)->count();
        } elseif ($level_caleg == 2) {
            $total_pendukung = CalegPendukungProv::where('celeg_id', $caleg_id)->count();
        } elseif ($level_caleg == 3) {
            $total_pendukung = CalegPendukungKabkota::where('celeg_id', $caleg_id)->count();
        }


        $list_bantuan = [];
        foreach ($bantuan as $item) {
            if ($level_caleg == 1) {
                $hitung_bantuan = CalegPendukungRi::where('klasifikasi_bantuan_id', $item->id)->count();
            } elseif ($level_caleg == 2) {
                $hitung_bantuan = CalegPendukungProv::where('klasifikasi_bantuan_id', $item->id)->count();
            } elseif ($level_caleg == 3) {
                $hitung_bantuan = CalegPendukungKabkota::where('klasifikasi_bantuan_id', $item->id)->count();
            }
            array_push($list_bantuan, [
                'nama'    =>    $item->nama,
                'jumlah'    =>   $hitung_bantuan ?? null,
            ]);
        }

        // $list_referensi = [];
        // foreach ($referensi as $item) {
        //     if ($level_caleg == 1) {
        //         $hitung_referensi = CalegPendukungRi::where('referensi_id', $user_id)->count();
        //     } elseif ($level_caleg == 2) {
        //         $hitung_referensi = CalegPendukungProv::where('referensi_id', $user_id)->count();
        //     } elseif ($level_caleg == 2) {
        //         $hitung_referensi = CalegPendukungKabkota::where('referensi_id', $user_id)->count();
        //     }
        //     array_push($list_referensi, [
        //         'nama'    =>    $item->nama,
        //         'jumlah'    =>   $hitung_referensi,
        //     ]);
        // }

        $list_klasifikasi = [];
        foreach ($klasifikasi as $item) {
            if ($level_caleg == 1) {
                $hitung_klasifikasi = CalegPendukungRi::where('klasifikasi_id', $item->id)->count();
            } elseif ($level_caleg == 2) {
                $hitung_klasifikasi = CalegPendukungProv::where('klasifikasi_id', $item->id)->count();
            } elseif ($level_caleg == 3) {
                $hitung_klasifikasi = CalegPendukungKabkota::where('klasifikasi_id', $item->id)->count();
            }
            array_push($list_klasifikasi, [
                'nama'    =>    $item->nama,
                'jumlah'    =>   $hitung_klasifikasi ?? null,
            ]);
        }

        // dd($list_klasifikasi);

        return view('caleg.dashboard.index', [
            'title' => 'Dashboard',
            'total_pendukung' => $total_pendukung,
            'total_relawan' => $referensi->count(),
            'list_klasifikasi' => $list_klasifikasi,
            // 'list_referensi' => $list_referensi,
            'list_bantuan' => $list_bantuan,
            'dapil' => $dapil,
            'caleg' => $caleg,
        ]);
    }
}
