<?php

namespace App\Http\Controllers;

use App\Models\Tim;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class TimController extends Controller
{
    //
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $user_id = $request->session()->get('user_id');
        $tim = Tim::where('user_id', $user_id)->get();
        // dd($user_id);

        return view('caleg.tim.index', [
            'title' => 'Tim Kemenangan',
            'tim' => $tim,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('caleg.tim.create', [
            'title' => 'Tambah Tim Kemenangan',
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $validasi = [
            'nama' => ['required'],
            'keterangan' => ['required']
        ];

        $validateData = $request->validate($validasi);

        $validateData['user_id'] = $request->session()->get('user_id');
        $validateData['celeg_id'] = $request->session()->get('caleg_id');
        $validateData['is_active'] = 1;

        // dd($validateData);

        Tim::create($validateData);

        return redirect('/tim')->with('pesan', 'data barhasil di tambah');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {

        $tim = Tim::where('id', $id)->first();

        return view('caleg.tim.edit', [
            'title' => 'Klasifikasi Bantuan',
            'tim' => $tim
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function update(Request $request, $id)
    {

        $tim = Tim::where('id', $id)->first();

        $validasi = [
            'nama' => ['required'],
            'keterangan' => ['required']
        ];

        $validateData = $request->validate($validasi);

        if (!$request->is_active) {
            $validateData['is_active'] = false;
        } else {
            $validateData['is_active'] = true;
        }

        Tim::where(
            'id',
            $tim->id
        )->update($validateData);

        return redirect("/tim")->with('pesan', 'data barhasil di ubah');
    }
}
