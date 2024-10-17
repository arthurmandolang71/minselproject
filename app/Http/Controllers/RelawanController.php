<?php

namespace App\Http\Controllers;

use App\Models\CalegPendukungKabkota;
use App\Models\CalegPendukungProv;
use App\Models\CalegPendukungRi;
use App\Models\Tim;
use App\Models\TimReferensi;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class RelawanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $user_id = $request->session()->get('user_id');
        $relawan = TimReferensi::with(['tim_ref', 'user_ref', 'pengikut_ref'])->get();

        // dd($relawan);

        return view('caleg.relawan.index', [
            'title' => 'Relawan',
            'relawan' => $relawan,
        ]);
    }

    public function show(Request $request, $id)
    {

        $relawan = TimReferensi::where('id', $id)->first();

        $level_caleg = $request->session()->get('level_caleg');

        if ($level_caleg == 1) {
            $pengikut = CalegPendukungRi::with(['pendukung_ref', 'pendukung_ref.kecamatan_ref', 'pendukung_ref.kelurahandesa_ref'])->where('referensi_id', $id)->orderBy("kk", "asc");
        } elseif ($level_caleg == 2) {
            $pengikut = CalegPendukungProv::with(['pendukung_ref', 'pendukung_ref.kecamatan_ref', 'pendukung_ref.kelurahandesa_ref'])->where('referensi_id', $id)->orderBy("kk", "asc");
        } elseif ($level_caleg == 3) {
            // $pengikut = CalegPendukungKabkota::with(['pendukung_ref', 'pendukung_ref.kecamatan_ref', 'pendukung_ref.kelurahandesa_ref'])->where('referensi_id', $id)->whereHas('pendukung_ref', function ($q) {
            //     $q->orderBy('tps', 'desc');
            // });

            // $pengikut = CalegPendukungKabkota::with([
            //     'pendukung_ref' => fn ($query) => $query->orderBy('tps', 'desc'), 'pendukung_ref.kecamatan_ref', 'pendukung_ref.kelurahandesa_ref'
            // ])->where('referensi_id', $id);

            $pengikut = CalegPendukungKabkota::with(['pendukung_ref', 'pendukung_ref.kecamatan_ref', 'pendukung_ref.kelurahandesa_ref'])->where('referensi_id', $id);
        }

        $total_kk = $pengikut->distinct()->count('kk');
        // dd($total_kk);

        return view('caleg.relawan.print', [
            'title' => 'Pengikut Relawan',
            'pengikut' => $pengikut->get(),
            'relawan' => $relawan,
            'total_kk' =>  $total_kk,
        ]);
    }

    public function create(Request $request)
    {
        $user_id = $request->session()->get('user_id');
        $tim = Tim::where('user_id', $user_id)->get();

        return view('caleg.relawan.create', [
            'title' => 'Tambah Relawan',
            'tim' => $tim
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, $id)
    {
        $relawan = TimReferensi::where('id', $id)->with(['user_ref'])->first();

        $user_id = $request->session()->get('user_id');
        $tim = Tim::where('user_id', $user_id)->get();

        return view('caleg.relawan.edit', [
            'title' => 'Ubah Data Relawan',
            'relawan' => $relawan,
            'tim' =>  $tim
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // dd($request);
        $validasi = [
            'tim_id' => ['required'],
            'nama' => ['required'],
            'nik' => ['required', 'unique:tim_referensi'],
            'no_wa' => ['required'],
            'keterangan' => ['required'],
            'target_pendukung' => [''],
        ];

        if ($request->file('foto_relawan')) {
            $validasi['foto_profil'] = ['image', 'file', 'mimes:jpeg,png,jpg', 'max:5024'];
        }

        $validateData = $request->validate($validasi);

        $level_caleg = session()->get('level_caleg');
        if ($level_caleg == 1) {
            $input_user['caleg_level'] = 1;
        } elseif ($level_caleg == 2) {
            $input_user['caleg_level'] = 2;
        } elseif ($level_caleg == 3) {
            $input_user['caleg_level'] = 3;
        }

        if ($request->file('foto_relawan')) {
            $file = $request->file('foto_relawan');
            $path = Storage::put('foto_relawan', $file);
            Storage::setVisibility($path, 'public');
            $validateData['foto_relawan'] = Storage::url($path);
        }

        $user_id_caleg = $request->session()->get('user_id');
        $caleg_id = $request->session()->get('caleg_id');
        $validateData['user_id_caleg'] = $user_id_caleg;
        $validateData['celeg_id'] = $caleg_id;
        $validateData['is_active'] = 1;

        $validateData['password'] = Hash::make($request->password);

        // $input_user['name'] = $validateData['nama'];
        // $input_user['username'] = $validateData['username'];
        // $input_user['password'] = $validateData['password'];
        // $input_user['active'] = $validateData['is_active'];
        // $input_user['foto_profil'] = $validateData['foto_relawan'] ?? NULL;
        // $input_user['level'] = 3;

        // // dd($input_user);

        // $user_input = User::create($input_user);

        // $validateData['user_id'] = $user_input->id;
        $validateData['user_id'] = 1;

        // dd($validateData);

        TimReferensi::create($validateData);

        return redirect('/dataprovider')->with('pesan', 'data barhasil di tambah');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $relawan = TimReferensi::where('id', $id)->with(['user_ref'])->first();
        $user = User::where('id', $relawan->user_id)->first();

        // dd($user);

        $validasi = [
            'tim_id' => ['required'],
            'nama' => ['required'],
            'no_wa' => ['required'],
            'keterangan' => ['required'],
            'target_pendukung' => [''],
        ];

        // if ($request->username != $user->username) {
        //     $validasi['username'] = ['required', 'unique:users', 'min:6'];
        // }

        // if ($request->password) {
        //     $validasi['password'] = ['required', 'min:6'];
        // }

        $validateData = $request->validate($validasi);

        // if ($request->file('foto_relawan')) {
        //     $file = $request->file('foto_relawan');
        //     $path = Storage::put('foto_relawan', $file);
        //     Storage::setVisibility($path, 'public');
        //     $validateData['foto_relawan'] = Storage::url($path);
        // }

        // if ($request->password) {
        //     $validateData['password'] = Hash::make($validateData['password']);
        //     $update_user['password'] = $validateData['password'];
        // }

        // if ($request->username != $user->username) {
        //     $update_user['username'] = $validateData['username'];
        // }

        if (!$request->sctive) {
            $validateData['active'] = false;
        } else {
            $validateData['active'] = true;
        }

        // dd($validateData['active']);

        $update_user['name'] = $validateData['nama'];
        $update_user['active'] = $validateData['is_active'];
        $update_user['foto_profil'] = $validateData['foto_relawan'] ?? NULL;

        if (!$request->is_active) {
            $validateData['is_active'] = false;
            $update_user['active'] = false;
        } else {
            $validateData['is_active'] = true;
            $update_user['active'] = true;
        }

        // User::where('id', $relawan->user_id)->update($update_user);

        TimReferensi::where('id', $id)->update($validateData);

        return redirect("/dataprovider")->with('pesan', 'data barhasil di update! silakan cek kembali');
    }
}
