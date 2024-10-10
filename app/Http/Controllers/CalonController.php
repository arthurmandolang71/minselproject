<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Partai;
use App\Models\CalegProv;
use App\Models\DapilProv;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class CalonController extends Controller
{

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $calon_pilkada = CalegProv::with(['user', 'partai', 'dapil'])->get();
        // dd($caleg_kabkota);
        return view('admin.calon.index', [
            'title' => 'Admin Calon Pilkada',
            'calon_pilkada' => $calon_pilkada,
        ]);
    }

    public function create()
    {

        $dapil_prov = DapilProv::all();
        $partai = Partai::all();

        // dd($kabupaten_kota);

        return view('admin.calon.create', [
            'title' => 'Tambah Client',
            'dapil_prov' => $dapil_prov,
            'partai' => $partai,
            'jenis_kelamin' => ['L', 'P']
        ]);
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id_caleg)
    {
        $dapil_prov = DapilProv::all();
        $partai = Partai::all();

        $cek_prov = CalegProv::find($id_caleg);
        if ($cek_prov) {
            $caleg_level = 2;
            $getcaleg = CalegProv::where('id', $id_caleg);
        }

        $caleg = $getcaleg->with('user')->first();

        // dd($caleg);

        return view('admin.calon.edit', [
            'title' => 'Set Ubah Data Client',
            'caleg' =>  $caleg,
            'caleg_level' =>  $caleg_level,
            'dapil_prov' => $dapil_prov,
            'partai' => $partai,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // dd($request);
        $validasi = [
            'username' => ['required', 'unique:users'],
            'partai_id' => ['required'],
            'nama' => ['required'],
            'no_urut' => ['required'],
            'keterangan' => [],
            'subdomain' => [],
        ];

        if ($request->file('foto_profil')) {
            $validasi['foto_profil'] = ['image', 'file', 'mimes:jpeg,png,jpg', 'max:5024'];
        }

        if ($request->file('banner_client')) {
            $validasi['banner_client'] = ['image', 'file', 'mimes:jpeg,png,jpg', 'max:5024'];
        }

        $validateData = $request->validate($validasi);

        if ($request->file('foto_profil')) {
            $file = $request->file('foto_profil');
            $path = Storage::put('foto_profil', $file);
            Storage::setVisibility($path, 'public');
            $insert_user['foto_profil'] = Storage::url($path);
        }

        if ($request->file('banner_client')) {
            $file = $request->file('banner_client');
            $path = Storage::put('banner_client', $file);
            Storage::setVisibility($path, 'public');
            $insert_user['banner_client'] = Storage::url($path);
        }

        $insert_user['active'] = 1;
        $insert_user['level'] = 2;
        $insert_user['username'] = $request->username;
        $insert_user['name'] = $request->nama;
        $insert_user['password'] = Hash::make($request->password);

        if ($request->dapil_prov) {

            $insert_user['caleg_level'] = 2;
            $user_created = User::create($insert_user);

            $validateData['dapil_prov'] = $request->dapil_prov;
            $validateData['user_id'] = $user_created->id;

            CalegProv::create($validateData);
        }



        return redirect('/calon')->with('pesan', 'data barhasil di tambah');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id_caleg)
    {
        $user = User::where('id', $request->user_id)->first();

        $validasi = [
            'partai_id' => ['required'],
            'nama' => ['required'],
            'no_urut' => ['required'],
            'keterangan' => [],
            'subdomain' => [],
        ];



        $validateData = $request->validate($validasi);

        if ($request->file('foto_profil')) {
            $file = $request->file('foto_profil');
            $path = Storage::put('foto_profil', $file);
            Storage::setVisibility($path, 'public');
            $user_update['foto_profil'] = Storage::url($path);
        }

        if ($request->file('banner_client')) {
            $file = $request->file('banner_client');
            $path = Storage::put('banner_client', $file);
            Storage::setVisibility($path, 'public');
            $user_update['banner_client'] = Storage::url($path);
        }

        if ($request->password) {
            $user_update['password'] = Hash::make($request->password);
        }

        if ($request->username != $user->username) {
            $user_update['username'] = ['required', 'unique:users', 'min:6'];
        }

        if (!$request->active) {
            $user_update['active'] = false;
        } else {
            $user_update['active'] = true;
        }

        // dd($validateData);
        CalegProv::where('id', $id_caleg)->update($validateData);

        User::where('id', $user->id)->update($user_update);

        return redirect("/calon")->with('pesan', 'data barhasil di update! silakan cek kembali');
    }
}
