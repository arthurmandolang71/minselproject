<?php

namespace App\Http\Controllers;

use App\Models\Dpt;
use App\Models\Tps;
use App\Models\DapilRi;
use App\Models\Kabkota;
use App\Models\Wilayah;
use App\Models\Provinsi;
use App\Models\RefAgama;
use App\Models\DapilProv;
use App\Models\Kecamatan;
use App\Models\DapilKabkota;
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
use App\Models\CalonPendukungReferensi;
use Illuminate\Support\Facades\Storage;


class PendukungCalegController extends Controller
{
    public function dashboard(Request $request)
    {

        //filter per dapil
        $level_caleg = $request->session()->get('level_caleg');
        $dapil_id = $request->session()->get('dapil_id');
        $dapil_kabkota = $request->session()->get('kabkota_dapil');
        $dapil_kecamatan = $request->session()->get('kecamatan_dapil');
        $caleg_id = $request->session()->get('caleg_id');

        $pendukung = null;

        // dd($total_pendukung);

        if ($level_caleg > 1) {
            $kabkota_dapil = $request->session()->get('kabkota_dapil');
            $kabkota_list = Kabkota::where('id', $kabkota_dapil)->get();
        } else {
            $kabkota_list = Kabkota::get();
        }


        // kalo default tapilih kelurahan
        if (
            request('kelurahandesa') != '' and
            request('kecamatan') != '' and request('kabkota') != '' and
            request('prov') != ''
        ) {
            $get_data = Wilayah::where('id', request('kelurahandesa'))->first();
            $get_data_turunan = Tps::where('wilayah_id', request('kelurahandesa'))->orderBy('nama', 'asc')->get();

            if ($level_caleg == 1) {
                $pendukung = CalegPendukungRi::cari(request(['kabkota', 'kecamatan', 'kelurahandesa']))->with(['pendukung_ref']);
                $jumlah_PB = CalegPendukungRi::cari(request(['kabkota', 'kecamatan', 'kelurahandesa']))->with(['pendukung_ref']);
                $jumlah_BB = CalegPendukungRi::cari(request(['kabkota', 'kecamatan', 'kelurahandesa']))->with(['pendukung_ref']);
                $jumlah_X = CalegPendukungRi::cari(request(['kabkota', 'kecamatan', 'kelurahandesa']))->with(['pendukung_ref']);
                $jumlah_Y = CalegPendukungRi::cari(request(['kabkota', 'kecamatan', 'kelurahandesa']))->with(['pendukung_ref']);
                $jumlah_Z = CalegPendukungRi::cari(request(['kabkota', 'kecamatan', 'kelurahandesa']))->with(['pendukung_ref']);

                $jenis_kelamin['L'] = CalegPendukungRi::cari(request(['kabkota', 'kecamatan', 'kelurahandesa']))->with(['pendukung_ref']);
                $jenis_kelamin['P'] = CalegPendukungRi::cari(request(['kabkota', 'kecamatan', 'kelurahandesa']))->with(['pendukung_ref']);
            } elseif ($level_caleg == 2) {
                $pendukung = CalegPendukungProv::cari(request(['kabkota', 'kecamatan', 'kelurahandesa']))->with(['pendukung_ref']);
                $jumlah_PB = CalegPendukungProv::cari(request(['kabkota', 'kecamatan', 'kelurahandesa']))->with(['pendukung_ref']);
                $jumlah_BB = CalegPendukungProv::cari(request(['kabkota', 'kecamatan', 'kelurahandesa']))->with(['pendukung_ref']);
                $jumlah_X = CalegPendukungProv::cari(request(['kabkota', 'kecamatan', 'kelurahandesa']))->with(['pendukung_ref']);
                $jumlah_Y = CalegPendukungProv::cari(request(['kabkota', 'kecamatan', 'kelurahandesa']))->with(['pendukung_ref']);
                $jumlah_Z = CalegPendukungProv::cari(request(['kabkota', 'kecamatan', 'kelurahandesa']))->with(['pendukung_ref']);

                $jenis_kelamin['L'] = CalegPendukungProv::cari(request(['kabkota', 'kecamatan', 'kelurahandesa']))->with(['pendukung_ref']);
                $jenis_kelamin['P'] = CalegPendukungProv::cari(request(['kabkota', 'kecamatan', 'kelurahandesa']))->with(['pendukung_ref']);
            } elseif ($level_caleg == 3) {
                $pendukung = CalegPendukungKabkota::cari(request(['kabkota', 'kecamatan', 'kelurahandesa']))->with(['pendukung_ref']);
                $jumlah_PB = CalegPendukungKabkota::cari(request(['kabkota', 'kecamatan', 'kelurahandesa']))->with(['pendukung_ref']);
                $jumlah_BB = CalegPendukungKabkota::cari(request(['kabkota', 'kecamatan', 'kelurahandesa']))->with(['pendukung_ref']);
                $jumlah_X = CalegPendukungKabkota::cari(request(['kabkota', 'kecamatan', 'kelurahandesa']))->with(['pendukung_ref']);
                $jumlah_Y = CalegPendukungKabkota::cari(request(['kabkota', 'kecamatan', 'kelurahandesa']))->with(['pendukung_ref']);
                $jumlah_Z = CalegPendukungKabkota::cari(request(['kabkota', 'kecamatan', 'kelurahandesa']))->with(['pendukung_ref']);

                $jenis_kelamin['L'] = CalegPendukungKabkota::cari(request(['kabkota', 'kecamatan', 'kelurahandesa']))->with(['pendukung_ref']);
                $jenis_kelamin['P'] = CalegPendukungKabkota::cari(request(['kabkota', 'kecamatan', 'kelurahandesa']))->with(['pendukung_ref']);
            }

            $where_turunan = 'tps';
        }

        // kalo default tapilih kecamatan
        elseif (
            request('kecamatan') != '' and request('kabkota') != '' and
            request('prov') != ''
        ) {
            $get_data = Kecamatan::where('id', request('kecamatan'))->first();
            $get_data_turunan = Wilayah::where('parent_id', request('kecamatan'))->get();

            if ($level_caleg == 1) {

                $pendukung = CalegPendukungRi::cari(request(['kabkota', 'kecamatan']))->with(['pendukung_ref']);
                $jumlah_PB = CalegPendukungRi::cari(request(['kabkota', 'kecamatan']))->with(['pendukung_ref']);
                $jumlah_BB = CalegPendukungRi::cari(request(['kabkota', 'kecamatan']))->with(['pendukung_ref']);
                $jumlah_X = CalegPendukungRi::cari(request(['kabkota', 'kecamatan']))->with(['pendukung_ref']);
                $jumlah_Y = CalegPendukungRi::cari(request(['kabkota', 'kecamatan']))->with(['pendukung_ref']);
                $jumlah_Z = CalegPendukungRi::cari(request(['kabkota', 'kecamatan']))->with(['pendukung_ref']);

                $jenis_kelamin['L'] = CalegPendukungRi::cari(request(['kabkota', 'kecamatan']))->with(['pendukung_ref']);
                $jenis_kelamin['P'] = CalegPendukungRi::cari(request(['kabkota', 'kecamatan']))->with(['pendukung_ref']);
            } elseif ($level_caleg == 2) {

                $pendukung = CalegPendukungProv::cari(request(['kabkota', 'kecamatan']))->with(['pendukung_ref']);
                $jumlah_PB = CalegPendukungProv::cari(request(['kabkota', 'kecamatan']))->with(['pendukung_ref']);
                $jumlah_BB = CalegPendukungProv::cari(request(['kabkota', 'kecamatan']))->with(['pendukung_ref']);
                $jumlah_X = CalegPendukungProv::cari(request(['kabkota', 'kecamatan']))->with(['pendukung_ref']);
                $jumlah_Y = CalegPendukungProv::cari(request(['kabkota', 'kecamatan']))->with(['pendukung_ref']);
                $jumlah_Z = CalegPendukungProv::cari(request(['kabkota', 'kecamatan']))->with(['pendukung_ref']);

                $jenis_kelamin['L'] = CalegPendukungProv::cari(request(['kabkota', 'kecamatan']))->with(['pendukung_ref']);
                $jenis_kelamin['P'] = CalegPendukungProv::cari(request(['kabkota', 'kecamatan']))->with(['pendukung_ref']);
            } elseif ($level_caleg == 3) {

                $pendukung = CalegPendukungKabkota::cari(request(['kabkota', 'kecamatan']))->with(['pendukung_ref']);
                $jumlah_PB = CalegPendukungKabkota::cari(request(['kabkota', 'kecamatan']))->with(['pendukung_ref']);
                $jumlah_BB = CalegPendukungKabkota::cari(request(['kabkota', 'kecamatan']))->with(['pendukung_ref']);
                $jumlah_X = CalegPendukungKabkota::cari(request(['kabkota', 'kecamatan']))->with(['pendukung_ref']);
                $jumlah_Y = CalegPendukungKabkota::cari(request(['kabkota', 'kecamatan']))->with(['pendukung_ref']);
                $jumlah_Z = CalegPendukungKabkota::cari(request(['kabkota', 'kecamatan']))->with(['pendukung_ref']);

                $jenis_kelamin['L'] = CalegPendukungKabkota::cari(request(['kabkota', 'kecamatan']))->with(['pendukung_ref']);
                $jenis_kelamin['P'] = CalegPendukungKabkota::cari(request(['kabkota', 'kecamatan']))->with(['pendukung_ref']);
            }

            $where_turunan = 'kelurahan_desa';
        }

        // kalo default tapilih kab kota
        elseif (
            request('kabkota') != '' and
            request('prov') != ''
        ) {
            // dpr kabupaten kota
            if ($level_caleg == 3) {
                $nama_dapil = Kabkota::whereIn('id', $dapil_kabkota)->first()->nama;
                $get_data_turunan = Kecamatan::whereIn('id', $dapil_kecamatan)->get();
                // $pendukung = CalegPendukungKabkota::cari([])->where('kabkota', $dapil_kabkota)->get();

                $pendukung = CalegPendukungKabkota::cari([''])->with(['pendukung_ref'])->whereHas('pendukung_ref', function ($query) use ($dapil_kabkota) {
                    $query->where('kabkota', $dapil_kabkota);
                });
                $jumlah_PB = CalegPendukungKabkota::cari([''])->with(['pendukung_ref'])->whereHas('pendukung_ref', function ($query) use ($dapil_kabkota) {
                    $query->where('kabkota', $dapil_kabkota);
                });;
                $jumlah_BB = CalegPendukungKabkota::cari([''])->with(['pendukung_ref'])->whereHas('pendukung_ref', function ($query) use ($dapil_kabkota) {
                    $query->where('kabkota', $dapil_kabkota);
                });;
                $jumlah_X = CalegPendukungKabkota::cari([''])->with(['pendukung_ref'])->whereHas('pendukung_ref', function ($query) use ($dapil_kabkota) {
                    $query->where('kabkota', $dapil_kabkota);
                });;
                $jumlah_Y = CalegPendukungKabkota::cari([''])->with(['pendukung_ref'])->whereHas('pendukung_ref', function ($query) use ($dapil_kabkota) {
                    $query->where('kabkota', $dapil_kabkota);
                });;
                $jumlah_Z = CalegPendukungKabkota::cari([''])->with(['pendukung_ref'])->whereHas('pendukung_ref', function ($query) use ($dapil_kabkota) {
                    $query->where('kabkota', $dapil_kabkota);
                });;

                $jenis_kelamin['L'] = CalegPendukungKabkota::cari([''])->with(['pendukung_ref'])->whereHas('pendukung_ref', function ($query) use ($dapil_kabkota) {
                    $query->where('kabkota', $dapil_kabkota);
                });;
                $jenis_kelamin['P'] = CalegPendukungKabkota::cari([''])->with(['pendukung_ref'])->whereHas('pendukung_ref', function ($query) use ($dapil_kabkota) {
                    $query->where('kabkota', $dapil_kabkota);
                });;
                // dd($pendukung);
            }
            // dpr provinsi dan dpr ri
            else {
                $nama_dapil = Kabkota::where('id', request('kabkota'))->first()->nama;
                $get_data_turunan = Kecamatan::where('parent_id', request('kabkota'))->get();

                if ($level_caleg == 1) {
                    $pendukung = CalegPendukungRi::cari(request(['kabkota']))->with(['pendukung_ref']);
                    $jumlah_PB = CalegPendukungRi::cari(request(['kabkota']))->with(['pendukung_ref']);
                    $jumlah_BB = CalegPendukungRi::cari(request(['kabkota']))->with(['pendukung_ref']);
                    $jumlah_X = CalegPendukungRi::cari(request(['kabkota']))->with(['pendukung_ref']);
                    $jumlah_Y = CalegPendukungRi::cari(request(['kabkota']))->with(['pendukung_ref']);
                    $jumlah_Z = CalegPendukungRi::cari(request(['kabkota']))->with(['pendukung_ref']);

                    $jenis_kelamin['L'] = CalegPendukungRi::cari(request(['kabkota']))->with(['pendukung_ref']);
                    $jenis_kelamin['P'] = CalegPendukungRi::cari(request(['kabkota']))->with(['pendukung_ref']);
                } elseif ($level_caleg == 2) {

                    $pendukung = CalegPendukungProv::cari(request(['kabkota']))->with(['pendukung_ref']);
                    $jumlah_PB = CalegPendukungProv::cari(request(['kabkota']))->with(['pendukung_ref']);
                    $jumlah_BB = CalegPendukungProv::cari(request(['kabkota']))->with(['pendukung_ref']);
                    $jumlah_X = CalegPendukungProv::cari(request(['kabkota']))->with(['pendukung_ref']);
                    $jumlah_Y = CalegPendukungProv::cari(request(['kabkota']))->with(['pendukung_ref']);
                    $jumlah_Z = CalegPendukungProv::cari(request(['kabkota']))->with(['pendukung_ref']);

                    $jenis_kelamin['L'] = CalegPendukungProv::cari(request(['kabkota']))->with(['pendukung_ref']);
                    $jenis_kelamin['P'] = CalegPendukungProv::cari(request(['kabkota']))->with(['pendukung_ref']);
                }
            }

            $where_turunan = 'kecamatan';
            $get_data = Kabkota::where('id', request('kabkota'))->first();
        }

        // kalo defualt utama
        elseif (
            request('prov') != ''
        ) {

            // dpr ri
            if ($level_caleg == 1) {
                $nama_dapil = DapilRi::where('id', $dapil_id)->first()->keterangan;
                $get_data_turunan = Kabkota::get();
                $where_turunan = 'kabkota';
            }
            // dpr provinsi$
            elseif ($level_caleg == 2) {
                $nama_dapil = DapilProv::where('id', $dapil_id)->first()->keterangan;
                $get_data_turunan = Kabkota::where('id', $dapil_kabkota)->get();
                $where_turunan = 'kabkota';
            }
            // dpr kabupaten kota
            elseif ($level_caleg == 3) {
                $nama_dapil = DapilKabkota::where('id', $dapil_id)->first()->keterangan;
                $get_data_turunan = Kecamatan::whereIn('id', $dapil_kecamatan)->get();
                $where_turunan = 'kecamatan';
            }

            $get_data = Provinsi::where('id', request('prov'))->first();
            $get_data->nama = $nama_dapil;

            if ($level_caleg == 1) {
                $pendukung = CalegPendukungRi::cari([''])->with(['pendukung_ref']);
                $jumlah_PB = CalegPendukungRi::cari([''])->with(['pendukung_ref']);
                $jumlah_BB = CalegPendukungRi::cari([''])->with(['pendukung_ref']);
                $jumlah_X = CalegPendukungRi::cari([''])->with(['pendukung_ref']);
                $jumlah_Y = CalegPendukungRi::cari([''])->with(['pendukung_ref']);
                $jumlah_Z = CalegPendukungRi::cari([''])->with(['pendukung_ref']);

                $jenis_kelamin['L'] = CalegPendukungRi::cari([''])->with(['pendukung_ref']);
                $jenis_kelamin['P'] = CalegPendukungRi::cari([''])->with(['pendukung_ref']);
            } elseif ($level_caleg == 2) {

                $pendukung = CalegPendukungProv::cari([''])->with(['pendukung_ref']);
                $jumlah_PB = CalegPendukungProv::cari([''])->with(['pendukung_ref']);
                $jumlah_BB = CalegPendukungProv::cari([''])->with(['pendukung_ref']);
                $jumlah_X = CalegPendukungProv::cari([''])->with(['pendukung_ref']);
                $jumlah_Y = CalegPendukungProv::cari([''])->with(['pendukung_ref']);
                $jumlah_Z = CalegPendukungProv::cari([''])->with(['pendukung_ref']);

                $jenis_kelamin['L'] = CalegPendukungProv::cari([''])->with(['pendukung_ref']);
                $jenis_kelamin['P'] = CalegPendukungProv::cari([''])->with(['pendukung_ref']);
            } elseif ($level_caleg == 3) {

                $pendukung = CalegPendukungKabkota::cari([''])->with(['pendukung_ref']);
                $jumlah_PB = CalegPendukungKabkota::cari([''])->with(['pendukung_ref']);
                $jumlah_BB = CalegPendukungKabkota::cari([''])->with(['pendukung_ref']);
                $jumlah_X = CalegPendukungKabkota::cari([''])->with(['pendukung_ref']);
                $jumlah_Y = CalegPendukungKabkota::cari([''])->with(['pendukung_ref']);
                $jumlah_Z = CalegPendukungKabkota::cari([''])->with(['pendukung_ref']);

                $jenis_kelamin['L'] = CalegPendukungKabkota::cari([''])->with(['pendukung_ref']);
                $jenis_kelamin['P'] = CalegPendukungKabkota::cari([''])->with(['pendukung_ref']);
            }
        }

        // dd($get_data_turunan);

        $list_turunan = [];
        foreach ($get_data_turunan as $item) {

            $itemid = $item->id;

            if ($level_caleg == 1) {
                $pendukung_turunan = CalegPendukungRi::cari([])->with(['pendukung_ref']);
            } elseif ($level_caleg == 2) {
                $pendukung_turunan = CalegPendukungProv::cari([])->with(['pendukung_ref']);
            } elseif ($level_caleg == 3) {
                $pendukung_turunan = CalegPendukungKabkota::cari([])->with(['pendukung_ref']);
            }

            if ($where_turunan == 'tps') {

                $itemnama = $item->nama;
                $itemwilayahid = $item->wilayah_id;
                $fresh_get = $pendukung_turunan->orderBy('nama', 'asc')->whereHas('pendukung_ref', function ($query) use ($itemnama, $itemwilayahid) {
                    $query->where('kelurahan_desa', $itemwilayahid)
                        ->where('tps', $itemnama);
                })->count();
            } else {

                $fresh_get = $pendukung_turunan->whereHas('pendukung_ref', function ($query) use ($where_turunan, $itemid) {
                    $query->where("$where_turunan", $itemid);
                })->count();
            }

            array_push($list_turunan, [
                'nama'    =>    $item->nama,
                'jumlah'    =>   $fresh_get ?? null,
            ]);
        }

        $jumlah_PB = $jumlah_PB->whereHas('pendukung_ref', function ($query) {
            $query->where('usia', 78);
        })->count();

        $jumlah_BB = $jumlah_BB->whereHas('pendukung_ref', function ($query) {
            $query->whereBetween('usia', [59, 77]);
        })->count();

        $jumlah_X = $jumlah_X->whereHas('pendukung_ref', function ($query) {
            $query->whereBetween('usia', [43, 58]);
        })->count();

        $jumlah_Y = $jumlah_Y->whereHas('pendukung_ref', function ($query) {
            $query->whereBetween('usia', [27, 42]);
        })->count();

        $jumlah_Z = $jumlah_Z->whereHas('pendukung_ref', function ($query) {
            $query->whereBetween('usia', [11, 26]);
        })->count();

        // $jenis_kelamin['L'] = $jenis_kelamin['L']->whereHas('pendukung_ref', function ($query) use ($dapil_kecamatan) {
        //     $query->where('kecamatan', $dapil_kecamatan)
        //         ->where('jenis_kelamin', 'L');
        // })->count();

        // $jenis_kelamin['P'] = $jenis_kelamin['P']->whereHas('pendukung_ref', function ($query) use ($dapil_kecamatan) {
        //     $query->where('kecamatan', $dapil_kecamatan)
        //         ->where('jenis_kelamin', 'P');
        // })->count();

        $jenis_kelamin['L'] = $jenis_kelamin['L']->whereHas('pendukung_ref', function ($query) {
            $query->where('jenis_kelamin', 'L');
        })->count();

        $jenis_kelamin['P'] = $jenis_kelamin['P']->whereHas('pendukung_ref', function ($query) {
            $query->where('jenis_kelamin', 'P');
        })->count();

        // dd($jenis_kelamin);


        return view('caleg.pendukung.dashboard', [
            'title' => "PENDUKUNG: $get_data->nama",
            'total_pemilih_turunan' => $pendukung->count(),
            'jenis_kelamin' => $jenis_kelamin ?? null,
            'list_turunan' => $list_turunan ?? null,
            'total_pemilih_PB' => $jumlah_PB,
            'total_pemilih_BB' => $jumlah_BB,
            'total_pemilih_X' => $jumlah_X,
            'total_pemilih_Y' => $jumlah_Y,
            'total_pemilih_Z' => $jumlah_Z,
            'kabkota_list' => $kabkota_list,
            'select_kabkota' => null,
            'select_kecamatan' => null,
            'select_kelurahandesa' => null,
            'select_tps' => null
        ]);
    }
    //
    public function index(Request $request)
    {
        //filter per dapil
        $level_caleg = $request->session()->get('level_caleg');
        $user_id = $request->session()->get('user_id');

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

        if (request('referensi') != '') {
            $get_referensi = TimReferensi::firstWhere('id', request('referensi'));
            $select_referensi = [
                'id' => $get_referensi->id,
                'nama' => $get_referensi->nama,
            ];
        } else {
            $select_referensi = NULL;
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

        // if ($level_caleg == 1) {
        //     $pendukung = CalegPendukungRi::with('klasifikasi_ref', 'bantuan_ref', 'relawan_ref', 'pendukung_ref', 'pendukung_ref.kabkota_ref', 'pendukung_ref.kecamatan_ref', 'pendukung_ref.kelurahandesa_ref')
        //         // ->orderBy("nama", "asc")
        //         ->orderBy("kk", "asc")
        //         ->cari(request(['kabkota', 'kecamatan', 'kelurahandesa', 'tps', 'bantuan ', 'referensi', 'klasifikasi', 'cari_nama']));
        // }

        // if ($level_caleg == 2) {
        //     $pendukung = CalegPendukungProv::with('klasifikasi_ref', 'bantuan_ref', 'relawan_ref', 'pendukung_ref', 'pendukung_ref.kabkota_ref', 'pendukung_ref.kecamatan_ref', 'pendukung_ref.kelurahandesa_ref')
        //         // ->orderBy("nama", "asc")
        //         ->orderBy("kk", "asc")
        //         ->cari(request(['kabkota', 'kecamatan', 'kelurahandesa', 'tps', 'bantuan ', 'referensi', 'klasifikasi', 'cari_nama']));
        // }

        // if ($level_caleg == 3) {
        //     $pendukung = CalegPendukungKabkota::with('klasifikasi_ref', 'bantuan_ref', 'relawan_ref', 'pendukung_ref', 'pendukung_ref.kabkota_ref', 'pendukung_ref.kecamatan_ref', 'pendukung_ref.kelurahandesa_ref')
        //         // ->orderBy("pendukung_ref.nama", "asc")
        //         ->orderBy("kk", "asc")
        //         ->cari(request(['kabkota', 'kecamatan', 'kelurahandesa', 'tps', 'bantuan ', 'referensi', 'klasifikasi', 'cari_nama']));
        // }


        $pendukung = CalegPendukungProv::with('klasifikasi_ref', 'bantuan_ref', 'relawan_ref', 'pendukung_ref', 'pendukung_ref.kabkota_ref', 'pendukung_ref.kecamatan_ref', 'pendukung_ref.kelurahandesa_ref')
            // ->orderBy("pendukung_ref.nama", "asc")
            ->orderBy("kk", "asc")
            ->cari(request(['kabkota', 'kecamatan', 'kelurahandesa', 'tps', 'bantuan ', 'referensi', 'klasifikasi', 'cari_nama']));


        if ($level_caleg > 1) {
            $kabkota_dapil = $request->session()->get('kabkota_dapil');
            $kabkota_list = Kabkota::where('id', $kabkota_dapil)->get();
        } else {
            $kabkota_list = Kabkota::get();
        }

        $referensi_list = TimReferensi::where('user_id_caleg', $user_id)->get();
        $bantuan_list = KlasifikasiBantuan::where('user_id', $user_id)->get();
        $klasifikasi_list = KlasifikasiPendukung::where('user_id', $user_id)->get();

        // dd($referensi_list);

        return view('caleg.pendukung.index', [
            'title' => 'Data Pendukung',
            'pendukung' => $pendukung->cursorPaginate(300)->withQueryString(),
            'total_get' => $pendukung->count(),
            'kabkota_list' => $kabkota_list,
            'referensi_list' => $referensi_list,
            'klasifikasi_list' => $klasifikasi_list,
            'bantuan_list' => $bantuan_list,
            'select_kabkota' => $select_kabkota,
            'select_kecamatan' => $select_kecamatan,
            'select_kelurahandesa' => $select_kelurahandesa,
            'select_bantuan' => $select_bantuan,
            'select_referensi' => $select_referensi,
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

        $user_id = $request->session()->get('user_id');
        $referensi = TimReferensi::get();
        $bantuan = KlasifikasiBantuan::get();
        $klasifikasi = KlasifikasiPendukung::get();

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
            $view = 'caleg.pendukung.form_caleg_kabkota';
        } elseif ($level_caleg == 2) {
            $view = 'caleg.pendukung.form_caleg_prov';
        } elseif ($level_caleg == 1) {
            $view = 'caleg.pendukung.form_caleg_ri';
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
            'referensi' => $referensi,
            'jenis_kelamin' => ['L', 'P'],
            'status_perkawinan' => ['Belum Kawin', 'Kawin', 'Cerai Hidup', 'Cerai Mati'],
            'status_keluarga' => ['SUAMI', 'ISTRI', 'ANAK/CUCU', 'MARTUA/ORANG TUA', 'SAUDARA/LAINYA'],
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
        $pendukung['alamat'] = $dpt->alamat;

        $pendukung_caleg['ktp'] = $request->ktp;
        $pendukung_caleg['tempat_lahir'] = $request->tempat_lahir;
        $pendukung_caleg['tanggal_lahir'] = $request->tanggal_lahir;
        $pendukung_caleg['agama'] = $request->agama;
        $pendukung_caleg['pekerjaan'] = $request->pekerjaan;
        $pendukung_caleg['alamat_detail'] = $request->alamat_detail;
        $pendukung_caleg['no_hp'] = $request->no_hp;
        $pendukung_caleg['no_wa'] = $request->no_wa;
        $pendukung_caleg['status_perkawinan'] = $request->status_perkawinan;
        $pendukung_caleg['referensi_id'] = $request->referensi_id;
        $pendukung_caleg['klasifikasi_id'] = $request->klasifikasi_id;
        $pendukung_caleg['klasifikasi_bantuan_id'] = $request->klasifikasi_bantuan_id;
        $pendukung_caleg['strtime_tanggal_lahir'] = strtotime($pendukung_caleg['tanggal_lahir']);
        $pendukung_caleg['long'] = $request->long;
        $pendukung_caleg['lat'] = $request->lat;
        $pendukung_caleg['dpt'] = $pendukung['dpt'];
        // $pendukung_caleg['kk'] = $request->kk;
        $pendukung_caleg['status_keluarga'] = $request->status_keluarga;


        $caleg_id = $request->session()->get('caleg_id');
        $pendukung_caleg['celeg_id'] = $caleg_id;

        // $level_caleg = $request->session()->get('level_caleg');
        // $dapil_id = $request->session()->get('dapil_id');

        $cek_sudah_input = CalegPendukungProv::where('dpt', $request->dpt_id)->where('celeg_id', $caleg_id)->first();
        if ($cek_sudah_input) {
            CalegPendukungProv::where('id', $cek_sudah_input->id)->update($pendukung_caleg);
        } else {
            // dd($pendukung_caleg);
            $pendukung_caleg['input_id'] = $request->session()->get('user_id');
            $pendukung_caleg['jml_referensi'] = 1;
            CalegPendukungProv::create($pendukung_caleg);
        }

        // dd($data);
        if ($status == 2) {
            // dd($pendukung);
            CalegPendukung::create($pendukung);
        }

        // return "berhasil";

        return redirect("$url")->with('pesan', 'Pendukung Berhasil di tambahkan');
    }

    public function create_referensi(Request $request, $id_dpt, $id_status)
    {

        // 1 sudah terinput di pendukung , 2 belum terinput di pendukung
        $agama = RefAgama::all();
        $pekerjaan = RefPekerjaan::all();
        $pendidikan = RefPendidikan::all();

        $user_id = $request->session()->get('user_id');
        $referensi = TimReferensi::get();
        $bantuan = KlasifikasiBantuan::get();
        $klasifikasi = KlasifikasiPendukung::get();

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

        $view = 'caleg.pendukung.form_tambah_referensi';

        return view($view, [
            'title' => 'Input Pendukung',
            'agama' => $agama,
            'dpt' => $dpt,
            'status' => $id_status,
            'pendidikan' => $pendidikan,
            'pekerjaan' => $pekerjaan,
            'bantuan' => $bantuan,
            'klasifikasi' => $klasifikasi,
            'referensi' => $referensi,
            'jenis_kelamin' => ['L', 'P'],
            'status_perkawinan' => ['Belum Kawin', 'Kawin', 'Cerai Hidup', 'Cerai Mati'],
            'status_keluarga' => ['SUAMI', 'ISTRI', 'ANAK/CUCU', 'MARTUA/ORANG TUA', 'SAUDARA/LAINYA'],
            'url_direct' => $url_direct
        ]);
    }

    public function daftar_referensi($id)
    {
        $referensi = CalonPendukungReferensi::with('relawan_ref')->where('id_calon_pendukung', $id)->get();
        $pendudukung = CalegPendukungProv::with('relawan_ref', 'pendukung_ref', 'pendukung_ref.kabkota_ref', 'pendukung_ref.kecamatan_ref', 'pendukung_ref.kelurahandesa_ref')->where('id', $id)->first();
        $url_direct = url()->previous();
        // dd($pendudukung);

        return view("caleg.pendukung.daftar_referensi", [
            'title' => 'Pemberi Data',
            'pendukung' => $pendudukung,
            'url_direct' => $url_direct,
            'pendukung_referensi' => $referensi,
        ]);
    }

    public function store_referensi(Request $request)
    {

        $pendukung_old = CalegPendukungProv::firstWhere('id', $request->pendukung_id);

        $pendukung['klasifikasi_id'] = $request->klasifikasi_id;
        $pendukung['jml_referensi'] = $pendukung_old->jml_referensi + 1;



        CalegPendukungProv::where('id', $request->pendukung_id)->update($pendukung);

        $referensi['id_calon_pendukung'] = $request->pendukung_id;
        $referensi['id_tim'] = $request->referensi_id;

        // dd($referensi);

        CalonPendukungReferensi::create($referensi);

        $url = $request->url_direct;

        return redirect("$url")->with('pesan', 'Pendukung Berhasil di tambahkan');
    }

    //
    public function pilih_print(Request $request)
    {
        //filter per dapil
        $level_caleg = $request->session()->get('level_caleg');
        $user_id = $request->session()->get('user_id');

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

        if (request('referensi') != '') {
            $get_referensi = TimReferensi::firstWhere('id', request('referensi'));
            $select_referensi = [
                'id' => $get_referensi->id,
                'nama' => $get_referensi->nama,
            ];
        } else {
            $select_referensi = NULL;
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
                // ->orderBy("nama", "asc")
                ->orderBy("kk", "asc")
                ->cari(request(['kabkota', 'kecamatan', 'kelurahandesa', 'tps', 'bantuan ', 'referensi', 'klasifikasi', 'cari_nama']));
        }

        if ($level_caleg == 2) {
            $pendukung = CalegPendukungProv::with('klasifikasi_ref', 'bantuan_ref', 'relawan_ref', 'pendukung_ref', 'pendukung_ref.kabkota_ref', 'pendukung_ref.kecamatan_ref', 'pendukung_ref.kelurahandesa_ref')
                // ->orderBy("nama", "asc")
                ->orderBy("kk", "asc")
                ->cari(request(['kabkota', 'kecamatan', 'kelurahandesa', 'tps', 'bantuan ', 'referensi', 'klasifikasi', 'cari_nama']));
        }

        if ($level_caleg == 3) {
            $pendukung = CalegPendukungKabkota::with('klasifikasi_ref', 'bantuan_ref', 'relawan_ref', 'pendukung_ref', 'pendukung_ref.kabkota_ref', 'pendukung_ref.kecamatan_ref', 'pendukung_ref.kelurahandesa_ref')
                // ->orderBy("pendukung_ref.nama", "asc")
                ->orderBy("kk", "asc")
                ->cari(request(['kabkota', 'kecamatan', 'kelurahandesa', 'tps', 'bantuan ', 'referensi', 'klasifikasi', 'cari_nama']));
        }

        if ($level_caleg > 1) {
            $kabkota_dapil = $request->session()->get('kabkota_dapil');
            $kabkota_list = Kabkota::where('id', $kabkota_dapil)->get();
        } else {
            $kabkota_list = Kabkota::get();
        }

        $referensi_list = TimReferensi::where('user_id_caleg', $user_id)->get();
        $bantuan_list = KlasifikasiBantuan::where('user_id', $user_id)->get();
        $klasifikasi_list = KlasifikasiPendukung::where('user_id', $user_id)->get();

        // dd($pendukung->get());

        $is_cetak = request('is_cetak');
        if ($is_cetak) {
            $view = 'caleg.pendukung.print_pendukung';
        } else {
            $view = 'caleg.pendukung.pilih_print';
        }

        return view($view, [
            'title' => 'Print Pendukung',
            'pendukung' => $pendukung->cursorPaginate(300)->withQueryString(),
            'total_get' => $pendukung->count(),
            'kabkota_list' => $kabkota_list,
            'referensi_list' => $referensi_list,
            'klasifikasi_list' => $klasifikasi_list,
            'bantuan_list' => $bantuan_list,
            'select_kabkota' => $select_kabkota,
            'select_kecamatan' => $select_kecamatan,
            'select_kelurahandesa' => $select_kelurahandesa,
            'select_bantuan' => $select_bantuan,
            'select_referensi' => $select_referensi,
            'select_klasifikasi' => $select_klasifikasi,
            'select_tps' => $select_tps,
            'cari_nama' => $cari_nama,
        ]);
    }

    public function destroy(Request $request, $id)
    {

        $level_caleg = $request->session()->get('level_caleg');

        if ($level_caleg == 3) {
            CalegPendukungKabkota::where('id', $id)->delete();
        }

        return redirect("/pendukung/index")->with('pesan', 'data barhasil di hapus! silakan cek kembali');
    }
}
