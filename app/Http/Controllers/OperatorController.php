<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Hash;
use PHPUnit\Framework\Constraint\Operator;

class OperatorController extends Controller
{
    //
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {

        $operator = User::where('level', 3)->get();
        // dd($relawan);
        //
        return view('caleg.operator.index', [
            'title' => 'Operator',
            'operator' => $operator,
        ]);
    }


    public function create(Request $request)
    {

        return view('caleg.operator.create', [
            'title' => 'Tambah Relawan',
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $operator = User::where('id', $id)->first();

        return view('caleg.operator.edit', [
            'title' => 'Ubah Data Relawan',
            'operator' => $operator,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // dd($request);
        $validasi = [
            'nama' => ['required'],
            'username' => ['required'],
            'password' => ['required'],
        ];


        $validateData = $request->validate($validasi);

        $validateData['password'] = Hash::make($request->password);

        $input_user['caleg_level'] = 2;
        $input_user['name'] = $validateData['nama'];
        $input_user['username'] = $validateData['username'];
        $input_user['password'] = $validateData['password'];
        $input_user['active'] = 1;
        $input_user['foto_profil'] = NULL;
        $input_user['level'] = 3;

        // dd($input_user);

        // dd($validateData);

        User::create($input_user);

        return redirect('/operator')->with('pesan', 'data barhasil di tambah');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {

        $user = User::where('id', $id)->first();

        // dd($user);

        $validasi = [
            // 'tim_id' => ['required'],
            'name' => ['required'],
            // 'no_wa' => ['required'],
            // 'keterangan' => ['required'],
            // 'target_pendukung' => [''],
        ];

        if ($request->username != $user->username) {
            $validasi['username'] = ['required', 'unique:users', 'min:6'];
        }

        if ($request->password) {
            $validasi['password'] = ['required', 'min:6'];
        }

        $validateData = $request->validate($validasi);

        if ($request->password) {
            $validateData['password'] = Hash::make($validateData['password']);
            $update_user['password'] = $validateData['password'];
        }

        if ($request->username != $user->username) {
            $update_user['username'] = $validateData['username'];
        }
        //

        if (!$request->active) {
            $validateData['active'] = false;
        } else {
            $validateData['active'] = true;
        }

        $update_user['name'] = $validateData['name'];
        $update_user['active'] = $validateData['active'];
        $update_user['foto_profil'] = $validateData['foto_relawan'] ?? NULL;

        if (!$request->active) {
            $update_user['active'] = false;
        } else {
            $update_user['active'] = true;
        }

        // User::where('id', $relawan->user_id)->update($update_user);

        User::where('id', $id)->update($update_user);

        return redirect("/operator")->with('pesan', 'data barhasil di update! silakan cek kembali');
    }
}
