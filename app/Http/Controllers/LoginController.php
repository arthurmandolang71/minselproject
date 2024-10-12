<?php

namespace App\Http\Controllers;

use App\Models\CalegRi;
use App\Models\CalegProv;
use App\Models\CalegKabkota;
use App\Models\CalegPendukungProv;
use Illuminate\Http\Request;
use App\Models\DapilProvWilayah;
use Illuminate\Routing\Controller;
use App\Models\DapilKabkotaWilayah;
use App\Models\Partai;
use App\Models\TimReferensi;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function index()
    {
        // dd('test');
        return view(
            'auth.login'
        );
    }

    public function auth(Request $request)
    {
        // dd($request->post());
        $cridentials = $request->validate(
            [
                'username' => ['required'],
                'password' => ['required']
            ]
        );

        $cridentials['active'] = 1;

        if (Auth::attempt($cridentials)) {
            $request->session()->regenerate();

            // Caleg
            if (auth()->user()->level == 1) {
                $request->session()->put('color', 'color_11');
                $request->session()->put('logo', 'logosementara.png');
                $request->session()->put('logo_text', 'logotextsementara.png');
            }

            if (auth()->user()->level == 2) {
                $level_caleg = auth()->user()->caleg_level;

                $caleg = CalegProv::where('user_id', auth()->user()->id)->first();
                // dd($caleg);
                $dapil = DapilProvWilayah::where('dapil_prov_id', $caleg->dapil_prov)->first();
                // dd($dapil);
                $request->session()->put('dapil_id', $caleg->dapil_prov);
                $request->session()->put('prov_dapil', 71);
                $request->session()->put('kabkota_dapil', $dapil->kabkota);

                $partai = Partai::where('id', $caleg->partai_id)->first();
                // dd($partai);

                $request->session()->put('logo', $partai->logo);
                $request->session()->put('logo_text', $partai->logo_text);
                $request->session()->put('color', $partai->color);

                $request->session()->put('level_caleg', $level_caleg);
                $request->session()->put('caleg_id', $caleg->id);
            }

            if (auth()->user()->level == 3) {
                $level_caleg = auth()->user()->caleg_level;
                $user_id_caleg = CalegProv::first()->user_id_caleg;



                if ($level_caleg == 2) {
                    $caleg = CalegProv::first();

                    $dapil = DapilProvWilayah::where('dapil_prov_id', $caleg->dapil_prov)->get();
                    $kabkota_dapil = [];
                    foreach ($dapil as $item) {
                        array_push($kabkota_dapil, $item->kabkota);
                    }

                    $request->session()->put('dapil_id', $caleg->dapil_prov);
                    $request->session()->put('prov_dapil', 71);
                    $request->session()->put('kabkota_dapil', $kabkota_dapil);
                }

                // dd($caleg->partai_id);
                $partai = Partai::where('id', $caleg->partai_id)->first();

                // $relawan = TimReferensi::where('user_id', auth()->user()->id)->first();

                $request->session()->put('relawan_id', auth()->user()->id);
                // $request->session()->put('logo', $partai->logo);
                // $request->session()->put('logo_text', $partai->logo_text);
                // $request->session()->put('color', $partai->color);

                $request->session()->put('level_caleg', $level_caleg);
                $request->session()->put('caleg_id', $caleg->id);
            }


            $id = auth()->user()->id;
            $username = auth()->user()->username;
            $name = auth()->user()->name;
            $foto = auth()->user()->foto;

            $request->session()->put('user_id', $id);
            $request->session()->put('username', $username);
            $request->session()->put('name', $name);
            $request->session()->put('foto', $foto);

            // dd(Auth::user());

            return redirect()->intended('/welcome');
        }

        return back()->with('pesan', 'Username atau password salah!');
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerate();

        return redirect('/login')->with('pesan', 'anda berhasil logout');
    }
}
