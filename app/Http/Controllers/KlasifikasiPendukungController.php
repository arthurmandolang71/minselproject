<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\Models\KlasifikasiPendukung;

class KlasifikasiPendukungController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $user_id = $request->session()->get('user_id');
        $klasifikasi_pendukung = KlasifikasiPendukung::where('user_id', $user_id)->get();
        // dd($user_id);

        return view('caleg.klasifikasipendukung.index', [
            'title' => 'Pengaturan Klasifikasi Pendukung',
            'klasifikasi_pendukung' => $klasifikasi_pendukung,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('caleg.klasifikasipendukung.create', [
            'title' => 'Tambah Klasifikasi Pendukung',
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

        KlasifikasiPendukung::create($validateData);

        return redirect('/klasifikasipendukung')->with('pesan', 'data barhasil di tambah');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(KlasifikasiPendukung $KlasifikasiPendukung, $id)
    {

        $KlasifikasiPendukung = KlasifikasiPendukung::where('id', $id)->first();

        return view('caleg.klasifikasipendukung.edit', [
            'title' => 'Klasifikasi Pendukung',
            'klasifikasi_pendukung' => $KlasifikasiPendukung
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function update(Request $request, $id)
    {

        $KlasifikasiPendukung = KlasifikasiPendukung::where('id', $id)->first();

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

        KlasifikasiPendukung::where(
            'id',
            $KlasifikasiPendukung->id
        )->update($validateData);

        return redirect("/klasifikasipendukung")->with('pesan', 'data barhasil di ubah');
    }
}
