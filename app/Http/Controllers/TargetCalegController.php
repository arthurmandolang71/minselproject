<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\CalegRi;
use App\Models\CalegProv;
use App\Models\CalegKabkota;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Gate;

class TargetCalegController extends Controller
{
    public function edit(Request $request)
    {
        // Gate::authorize('profil');

        $level = $request->session()->get('level_caleg');
        $user_id = $request->session()->get('user_id');

        $profil = User::where('id', $user_id)->first();

        if ($level == 1) {
            $target = CalegRi::where('user_id', $user_id)->first();
        }

        if ($level == 2) {
            $target = CalegProv::where('user_id', $user_id)->first();
        }

        if ($level == 3) {
            $target = CalegKabkota::where('user_id', $user_id)->first();
        }

        // dd($target);

        return view('caleg.target.edit', [
            'title' => 'Edit Password',
            'target' => $target,
            'profil' => $profil,
        ]);
    }

    public function update(Request $request)
    {
        $level = $request->session()->get('level_caleg');
        $user_id = $request->session()->get('user_id');

        $update = ['target_pendukung' => $request->target_pendukung];

        if ($level == 1) {
            CalegRi::where('user_id', $user_id)->update($update);
        }

        if ($level == 2) {
            CalegProv::where('user_id', $user_id)->update($update);
        }

        if ($level == 3) {
            CalegKabkota::where('user_id', $user_id)->update($update);
        }

        return redirect("/target/edit")->with('pesan', 'target berhasil di ubah');
    }
}
