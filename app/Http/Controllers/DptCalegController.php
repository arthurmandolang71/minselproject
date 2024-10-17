<?php

namespace App\Http\Controllers;

use App\Models\Dpt;
use App\Models\Tps;
use App\Models\DapilRi;
use App\Models\Kabkota;
use App\Models\Wilayah;
use App\Models\Provinsi;
use App\Models\DapilProv;
use App\Models\Kecamatan;
use App\Models\DapilKabkota;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class DptCalegController extends Controller
{

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        //filter per dapil
        $level_caleg = $request->session()->get('level_caleg');

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

        $dpt = Dpt::with(['kabkota_ref', 'kecamatan_ref', 'kelurahandesa_ref'])
            ->orderBy("nama", "asc")
            ->cari(request(['kabkota', 'kecamatan', 'kelurahandesa', 'tps', 'cari_nama']));



        $dpt->with('pendukung', 'pendukung.pendukung_caleg_prov');


        $kabkota_dapil = $request->session()->get('kabkota_dapil');
        $kabkota_list = Kabkota::where('id', $kabkota_dapil)->get();

        // dd($request->session()->get('kabkota_dapil'));

        return view('caleg.dpt.index', [
            'title' => 'Cari Nama DPT 2024',
            'pemilih' => $dpt->cursorPaginate(300)->withQueryString(),
            'total_get' => $dpt->count(),
            'kabkota_list' => $kabkota_list,
            'select_kabkota' => $select_kabkota,
            'select_kecamatan' => $select_kecamatan,
            'select_kelurahandesa' => $select_kelurahandesa,
            'select_tps' => $select_tps,
            'level_caleg' =>  $level_caleg,
            'cari_nama' => $cari_nama,
        ]);
    }

    public function dashboard(Request $request)
    {
        //filter per dapil
        ini_set('memory_limit', '512M');
        ini_set('max_execution_time', 300);

        $level_caleg = $request->session()->get('level_caleg');
        $dapil_id = $request->session()->get('dapil_id');
        $dapil_kabkota = $request->session()->get('kabkota_dapil');
        $dapil_kecamatan = $request->session()->get('kecamatan_dapil');

        // dd($dapil_kabkota);

        $kabkota_dapil = $request->session()->get('kabkota_dapil');
        $kabkota_list = Kabkota::where('id', $kabkota_dapil)->get();

        // kalo default tapilih kelurahan
        if (
            request('kelurahandesa') != '' and
            request('kecamatan') != '' and request('kabkota') != '' and
            request('prov') != ''
        ) {
            $get_data = Wilayah::where('id', request('kelurahandesa'))->first();
            $get_data_turunan = Tps::where('wilayah_id', request('kelurahandesa'));
            $jenis_kelamin = Dpt::select('jenis_kelamin')->where('kelurahan_desa', request('kelurahandesa'))->get();
        }

        // kalo default tapilih kecamatan
        elseif (
            request('kecamatan') != '' and request('kabkota') != '' and
            request('prov') != ''
        ) {
            $get_data = Kecamatan::where('id', request('kecamatan'))->first();
            $get_data_turunan = Wilayah::where('parent_id', request('kecamatan'));
            $jenis_kelamin = Dpt::select('jenis_kelamin')->where('kecamatan', request('kecamatan'))->get();
        }

        // kalo default tapilih kab kota
        elseif (
            request('kabkota') != '' and
            request('prov') != ''
        ) {
            // dpr kabupaten kota
            if ($level_caleg == 3) {
                $nama_dapil = Kabkota::whereIn('id', $dapil_kabkota)->first()->nama;
                $get_data_turunan = Kecamatan::whereIn('id', $dapil_kecamatan);
                $jenis_kelamin = Dpt::select('jenis_kelamin')->where('kecamatan', $dapil_kecamatan)->get();
            }
            // dpr provinsi dan dpr ri
            else {
                $nama_dapil = Kabkota::where('id', request('kabkota'))->first()->nama;
                $get_data_turunan = Kecamatan::where('parent_id', request('kabkota'));
                $jenis_kelamin = Dpt::select('jenis_kelamin')->where('kabkota', request('kabkota'))->get();
            }

            $get_data = Kabkota::where('id', request('kabkota'))->first();
        }

        // kalo defualt utama
        elseif (
            request('prov') != ''
        ) {

            //ambil keterangan dapil dan total keseluruhan perdapil dan jenis kelamin per dapil
            $get_data = Provinsi::where('id', request('prov'))->first();


            // dpr provinsi

            $nama_dapil = DapilProv::where('id', $dapil_id)->first()->keterangan;
            $get_data_turunan = Kabkota::where('id', $dapil_kabkota);
            $jenis_kelamin = Dpt::select('jenis_kelamin')->where('kabkota', $dapil_kabkota)->get();



            $get_data->nama = $nama_dapil;
        }

        //per jenis kelamin
        $jenis_kelamin = $jenis_kelamin->countBy('jenis_kelamin');

        $list_turunan = $get_data_turunan->get();
        $total_turunan = $get_data_turunan->count();
        $total_pemilih_turunan = $get_data_turunan->sum('jumlah');
        $total_pemilih_PB = $get_data_turunan->sum('jumlah_PB');
        $total_pemilih_BB = $get_data_turunan->sum('jumlah_BB');
        $total_pemilih_X = $get_data_turunan->sum('jumlah_X');
        $total_pemilih_Y = $get_data_turunan->sum('jumlah_Y');
        $total_pemilih_Z = $get_data_turunan->sum('jumlah_Z');

        // dd($jenis_kelamin);

        return view('caleg.dpt.dashboard', [
            'title' => "DPT : $get_data->nama",
            'jenis_kelamin' => $jenis_kelamin,
            'list_turunan' => $list_turunan,
            'total_turunan' => $total_turunan,
            'total_pemilih_turunan' => $total_pemilih_turunan,
            'total_pemilih_PB' => $total_pemilih_PB,
            'total_pemilih_BB' => $total_pemilih_BB,
            'total_pemilih_X' => $total_pemilih_X,
            'total_pemilih_Y' => $total_pemilih_Y,
            'total_pemilih_Z' => $total_pemilih_Z,
            'kabkota_list' => $kabkota_list,
            'select_kabkota' => null,
            'select_kecamatan' => null,
            'select_kelurahandesa' => null,
            'select_tps' => null
        ]);
    }

    public function create()
    {

        $kabkota = Kabkota::all();
        $kecamatan = Kecamatan::all();
        $kelurahan_desa = Wilayah::all();

        // dd($kabupaten_kota);

        return view('caleg.dpt.create', [
            'title' => 'Tambah DPT',
            'kabkota' => $kabkota,
            'kecamatan' => $kecamatan,
            'kelurahan_desa' => $kelurahan_desa,
            'tps' => ['001', '002', '003', '004', '005', '006', '007', '008', '009', '010', '011', '012', '013', '014', '015', '016', '017', '018', '019', '020', '021', '022', '023', '024', '025', '026', '027', '028', '029', '030'],
            'jenis_kelamin' => ['L', 'P'],
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
            'jenis_kelamin' => ['required'],
            'usia' => ['required'],
            'tps' => ['required'],
            'alamat' => ['required'],
        ];

        $validateData = $request->validate($validasi);

        $validateData['kabkota'] = $request->post('kabkota');
        $validateData['kecamatan'] = $request->post('kecamatan');
        $validateData['kelurahan_desa'] = $request->post('kelurahandesa');
        $validateData['wilayah_id'] = $request->post('kelurahandesa');

        $validateData['rt'] = '0';
        $validateData['rw'] = '0';

        // dd($validateData);

        Dpt::create($validateData);

        return redirect('/collectdata')->with('pesan', 'data barhasil di tambah silakan cari di DPT');
    }

    public function getKecamatan(Request $request, $kabkota_id = 0)
    {
        $level_caleg = $request->session()->get('level_caleg');
        if ($level_caleg == 3) {
            $kecamatan_dapil = $request->session()->get('kecamatan_dapil');
            $data['data'] = Kecamatan::orderby("nama", "asc")
                ->where('parent_id', $kabkota_id)
                ->whereIn('kode_kec', $kecamatan_dapil)
                ->get();
        } else {
            $data['data'] = Kecamatan::orderby("nama", "asc")
                ->where('parent_id', $kabkota_id)
                ->get();
        }

        return response()->json($data);
    }

    public function getKelurahanDesa($kecamatan_id = 0)
    {
        $data['data'] = Wilayah::orderby("nama", "asc")
            ->where('parent_id', $kecamatan_id)
            ->get();
        return response()->json($data);
    }

    public function getTps($wilayah_id = 0)
    {
        $data['data'] = Tps::orderby("nama", "asc")
            ->where('wilayah_id', $wilayah_id)
            ->get();
        return response()->json($data);
    }
}
