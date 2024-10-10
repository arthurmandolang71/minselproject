<?php

namespace App\Http\Controllers;

use App\Models\KlasifikasiBantuan;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class KlasifikasiBantuanController extends Controller
{
    //
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $user_id = $request->session()->get('user_id');
        $klasifikasi_bantuan = KlasifikasiBantuan::where('user_id', $user_id)->get();
        // dd($user_id);

        return view('caleg.klasifikasibantuan.index', [
            'title' => 'Pengaturan Klasifikasi Bantuan',
            'klasifikasi_bantuan' => $klasifikasi_bantuan,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('caleg.klasifikasibantuan.create', [
            'title' => 'Tambah Klasifikasi Bantuan',
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

        KlasifikasiBantuan::create($validateData);

        return redirect('/klasifikasibantuan')->with('pesan', 'data barhasil di tambah');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {

        $Klasifikasibantuan = KlasifikasiBantuan::where('id', $id)->first();

        return view('caleg.klasifikasibantuan.edit', [
            'title' => 'Klasifikasi Bantuan',
            'klasifikasi_bantuan' => $Klasifikasibantuan
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function update(Request $request, $id)
    {

        $Klasifikasibantuan = KlasifikasiBantuan::where('id', $id)->first();

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

        KlasifikasiBantuan::where(
            'id',
            $Klasifikasibantuan->id
        )->update($validateData);

        return redirect("/klasifikasibantuan")->with('pesan', 'data barhasil di ubah');
    }
}
