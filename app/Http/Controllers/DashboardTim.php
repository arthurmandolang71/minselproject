<?php

namespace App\Http\Controllers;

use App\Models\CalegRi;
use App\Models\DapilRi;
use App\Models\CalegProv;
use App\Models\DapilProv;
use App\Models\CalegKabkota;
use App\Models\DapilKabkota;
use Illuminate\Http\Request;
use App\Models\CalegPendukungRi;
use App\Models\CalegPendukungProv;
use App\Models\KlasifikasiBantuan;
use Illuminate\Routing\Controller;
use App\Models\KlasifikasiPendukung;
use App\Models\CalegPendukungKabkota;
use App\Models\TimReferensi;

class DashboardTim extends Controller
{
    //
    public function index(Request $request)
    {

        $level_caleg = $request->session()->get('level_caleg');
        $dapil_id = $request->session()->get('dapil_id');
        $user_id = $request->session()->get('user_id');
        $user_id_caleg = $request->session()->get('user_id_caleg');
        $caleg_id = $request->session()->get('caleg_id');
        $relawan_id = $request->session()->get('relawan_id');

        // dd($user_id_caleg);

        $bantuan = KlasifikasiBantuan::where('user_id', $user_id_caleg)->get();
        $klasifikasi = KlasifikasiPendukung::where('user_id', $user_id_caleg)->get();
        $relawan = TimReferensi::where('user_id', $user_id)->first();



        if ($level_caleg == 1) {
            $dapil = DapilRi::where('id', $dapil_id)->first();
            $caleg = CalegRi::where('user_id', $user_id_caleg)->first();
        } elseif ($level_caleg == 2) {
            $dapil = DapilProv::where('id', $dapil_id)->first();
            $caleg = CalegProv::where('user_id', $user_id_caleg)->first();
        } elseif ($level_caleg == 3) {
            $dapil = DapilKabkota::where('id', $dapil_id)->first();
            $caleg = CalegKabkota::where('user_id', $user_id_caleg)->first();
        }

        // dd($caleg);

        if ($level_caleg == 1) {
            $total_pendukung = CalegPendukungRi::where('referensi_id', $relawan->id)->count();
        } elseif ($level_caleg == 2) {
            $total_pendukung = CalegPendukungProv::where('referensi_id', $relawan->id)->count();
        } elseif ($level_caleg == 3) {
            $total_pendukung = CalegPendukungKabkota::where('referensi_id', $relawan->id)->count();
        }


        $list_bantuan = [];
        foreach ($bantuan as $item) {
            if ($level_caleg == 1) {
                $hitung_bantuan = CalegPendukungRi::where('klasifikasi_bantuan_id', $item->id)
                    ->where('referensi_id', $relawan_id)->count();
            } elseif ($level_caleg == 2) {
                $hitung_bantuan = CalegPendukungProv::where('klasifikasi_bantuan_id', $item->id)
                    ->where('referensi_id', $relawan_id)->count();
            } elseif ($level_caleg == 3) {
                $hitung_bantuan = CalegPendukungKabkota::where('klasifikasi_bantuan_id', $item->id)
                    ->where('referensi_id', $relawan_id)->count();
            }
            array_push($list_bantuan, [
                'nama'    =>    $item->nama,
                'jumlah'    =>   $hitung_bantuan ?? null,
            ]);
        }


        $list_klasifikasi = [];
        foreach ($klasifikasi as $item) {
            if ($level_caleg == 1) {
                $hitung_klasifikasi = CalegPendukungRi::where('klasifikasi_id', $item->id)
                    ->where('referensi_id', $relawan_id)->count();
            } elseif ($level_caleg == 2) {
                $hitung_klasifikasi = CalegPendukungProv::where('klasifikasi_id', $item->id)
                    ->where('referensi_id', $relawan_id)->count();
            } elseif ($level_caleg == 3) {
                $hitung_klasifikasi = CalegPendukungKabkota::where('klasifikasi_id', $item->id)
                    ->where('referensi_id', $relawan_id)->count();
            }
            array_push($list_klasifikasi, [
                'nama'    =>    $item->nama,
                'jumlah'    =>   $hitung_klasifikasi ?? null,
            ]);
        }

        // dd($relawan);

        return view('tim.dashboard.index', [
            'title' => 'Dashboard',
            'total_pendukung' => $total_pendukung,
            'list_klasifikasi' => $list_klasifikasi,
            'list_bantuan' => $list_bantuan,
            'dapil' => $dapil,
            'caleg' => $caleg,
            'relawan' => $relawan,
        ]);
    }
}
