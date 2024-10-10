<?php

namespace App\Http\Controllers;

use App\Models\Dpt;
use App\Models\Tps;
use App\Models\Kabkota;
use App\Models\Wilayah;
use App\Models\Kecamatan;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Collection;

class DptController extends Controller
{
    //

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $kelurahan_desa = Wilayah::with(['tps', 'kabkota', 'kecamatan'])->get();

        return view('admin.dpt.index', [
            'title' => 'DPT 2024',
            'kelurahan_desa' => $kelurahan_desa,
        ]);
    }

    public function create()
    {
        // dd('hallo');
        $kecamatan = Kecamatan::all();

        return view('admin.dpt.create', [
            'title' => "import DPT 2024",
            'kecamatan' => $kecamatan
        ]);
    }

    public function store(Request $request)
    {
        //ambil id kabtota
        $kabkota_id = Kecamatan::where('id', $request->kecamatan_id)->first()->parent_id;

        $file = $request->file('file_csv')->getPathName();

        $data =  array_map('str_getcsv', file($file));

        unset($data[0]);

        // $cek_errot = $data[0][3];

        for ($i = 1; $i <= count($data); $i++) {

            $dpt_2024 = explode(";", $data[$i][0]);
            // dd($dpt_2024[2]);

            $pemilih[] = array(
                'id' => Str::uuid(),
                'nama'    =>    $dpt_2024[1],
                'jenis_kelamin'    =>    $dpt_2024[2],
                'usia'    =>    $dpt_2024[3],
                'kabkota'    =>    $kabkota_id,
                'kecamatan'    =>    $request->kecamatan_id,
                'kelurahan_desa'    =>    $request->wilayah_id,
                'alamat'    =>    $dpt_2024[7],
                'rt'    =>    $dpt_2024[8],
                'rw'    =>    $dpt_2024[9],
                'tps'    =>    $dpt_2024[10],
                'wilayah_id'    =>    $request->wilayah_id,
            );
        }

        // dd($pemilih);

        // ekstrak kelurahan
        $collection_pemilih = new Collection($pemilih);

        // hitung total per wilayah/kelurahan
        $total_pemilih_kelurahan = $collection_pemilih->count();

        $kabkota = Kabkota::find($kabkota_id);
        $kecamatan = kecamatan::find($request->kecamatan_id);

        $cek_jumlah_kelurahan = Wilayah::where('id', $request->wilayah_id)->first();
        $cek_jumlah_kelurahan_if = Wilayah::where('id', $request->wilayah_id)->first()->jumlah;
        if ($cek_jumlah_kelurahan_if > 0) {
            // reset dulu total di tabel kabkota
            $kabkota->jumlah_PB = intval($kabkota->jumlah_PB) - intval($cek_jumlah_kelurahan->jumlah_PB);
            $kabkota->jumlah_BB = intval($kabkota->jumlah_BB) - intval($cek_jumlah_kelurahan->jumlah_BB);
            $kabkota->jumlah_X = intval($kabkota->jumlah_X) - intval($cek_jumlah_kelurahan->jumlah_X);
            $kabkota->jumlah_Y = intval($kabkota->jumlah_Y) - intval($cek_jumlah_kelurahan->jumlah_Y);
            $kabkota->jumlah_Z = intval($kabkota->jumlah_Z) - intval($cek_jumlah_kelurahan->jumlah_Z);

            $kabkota->jumlah =  intval($kabkota->jumlah) - intval($cek_jumlah_kelurahan->jumlah);

            $kabkota->save();

            // reset dulu total di tabel kecamatan
            $kecamatan->jumlah_PB = intval($kecamatan->jumlah_PB) - intval($cek_jumlah_kelurahan->jumlah_PB);
            $kecamatan->jumlah_PB = intval($kecamatan->jumlah_BB) - intval($cek_jumlah_kelurahan->jumlah_BB);
            $kecamatan->jumlah_PB = intval($kecamatan->jumlah_X) - intval($cek_jumlah_kelurahan->jumlah_X);
            $kecamatan->jumlah_PB = intval($kecamatan->jumlah_Y) - intval($cek_jumlah_kelurahan->jumlah_Y);
            $kecamatan->jumlah_PB = intval($kecamatan->jumlah_Z) - intval($cek_jumlah_kelurahan->jumlah_Z);

            $kecamatan->jumlah = intval($kecamatan->jumlah) - intval($cek_jumlah_kelurahan->jumlah);

            $kecamatan->save();
        }

        $jumlah_PB = $collection_pemilih->where('usia', '>=', 78)->count();
        $jumlah_BB = $collection_pemilih->whereBetween('usia', [59, 77])->count();
        $jumlah_X = $collection_pemilih->whereBetween('usia', [43, 58])->count();
        $jumlah_Y = $collection_pemilih->whereBetween('usia', [27, 42])->count();
        $jumlah_Z = $collection_pemilih->whereBetween('usia', [11, 26])->count();

        //update nilai kabkota
        $kabkota->jumlah_PB  =  intval($kabkota->jumlah_PB) + $jumlah_PB;
        $kabkota->jumlah_BB  =  intval($kabkota->jumlah_BB) + $jumlah_BB;
        $kabkota->jumlah_X  =  intval($kabkota->jumlah_X) + $jumlah_X;
        $kabkota->jumlah_Y  =  intval($kabkota->jumlah_Y) + $jumlah_Y;
        $kabkota->jumlah_Z  =  intval($kabkota->jumlah_Z) + $jumlah_Z;

        $kabkota->jumlah = intval($kabkota->jumlah) + $total_pemilih_kelurahan;

        $kabkota->save();

        //update nilai kecamatan
        $kecamatan->jumlah_PB = intval($kecamatan->jumlah_PB) + $jumlah_PB;
        $kecamatan->jumlah_BB = intval($kecamatan->jumlah_BB) + $jumlah_BB;
        $kecamatan->jumlah_X = intval($kecamatan->jumlah_X) + $jumlah_X;
        $kecamatan->jumlah_Y = intval($kecamatan->jumlah_Y) + $jumlah_Y;
        $kecamatan->jumlah_Z = intval($kecamatan->jumlah_Z) + $jumlah_Z;

        $kecamatan->jumlah =  intval($kecamatan->jumlah) + $total_pemilih_kelurahan;

        $kecamatan->save();

        // update di tabel kelurahan desa/ wilayah
        Wilayah::where('id', $request->wilayah_id)->update(['jumlah_PB' => $jumlah_PB]);
        Wilayah::where('id', $request->wilayah_id)->update(['jumlah_BB' => $jumlah_BB]);
        Wilayah::where('id', $request->wilayah_id)->update(['jumlah_X' => $jumlah_X]);
        Wilayah::where('id', $request->wilayah_id)->update(['jumlah_Y' => $jumlah_Y]);
        Wilayah::where('id', $request->wilayah_id)->update(['jumlah_Z' => $jumlah_Z]);
        Wilayah::where('id', $request->wilayah_id)->update(['jumlah' => $total_pemilih_kelurahan]);

        // hapus dulu yang so pernah simpan di dpt dengan tps
        Dpt::where('wilayah_id', $request->wilayah_id)->delete();
        Tps::where('wilayah_id', $request->wilayah_id)->delete();

        // insert tabel tps
        // $total_tps = $collection_pemilih->max('tps');

        $get_tps = $collection_pemilih->groupBy('tps');

        foreach ($get_tps as $key => $node) {

            $total_pemilih_tps_PB = $collection_pemilih->where('usia', '>=', 78)->where('tps', '==', $key)->count();
            $total_pemilih_tps_BB = $collection_pemilih->whereBetween('usia', [59, 77])->where('tps', '==', $key)->count();
            $total_pemilih_tps_X = $collection_pemilih->whereBetween('usia', [43, 58])->where('tps', '==', $key)->count();
            $total_pemilih_tps_Y = $collection_pemilih->whereBetween('usia', [27, 42])->where('tps', '==', $key)->count();
            $total_pemilih_tps_Z = $collection_pemilih->whereBetween('usia', [11, 26])->where('tps', '==', $key)->count();

            $total_pemilih_tps = $collection_pemilih->where('tps', '==', $key)->count();

            $insert_tps[] = array(
                'id' => Str::uuid(),
                'wilayah_id' => $request->wilayah_id,
                'nama' => $key,
                'jumlah' => $total_pemilih_tps,
                'total_pemilih_kelurahan' =>  $total_pemilih_kelurahan,
                'jumlah_PB' => $total_pemilih_tps_PB,
                'jumlah_BB' => $total_pemilih_tps_BB,
                'jumlah_X' => $total_pemilih_tps_X,
                'jumlah_Y' => $total_pemilih_tps_Y,
                'jumlah_Z' => $total_pemilih_tps_Z,
                'kabkota' => $collection_pemilih[0]['kabkota'],
                'kecamatan' => $collection_pemilih[0]['kecamatan'],
                'kelurahan_desa' => $collection_pemilih[0]['kelurahan_desa'],
            );
        }
        // baru isi ulang di tps
        Tps::insert($insert_tps);

        // baru isi ulang di dpt
        foreach (array_chunk($pemilih, 100) as $item) {
            Dpt::insertOrIgnore($item);
        }
        // insert dpt


        return redirect('/dpt/create')->with('pesan', 'data bashasil di export');
    }

    public function getKecamatan($kabkota_id = 0)
    {
        $data['data'] = Kecamatan::orderby("nama", "asc")
            ->where('parent_id', $kabkota_id)
            ->get();
        return response()->json($data);
    }

    public function getKelurahanDesa($kecamatan_id = 0)
    {
        $data['data'] = Wilayah::orderby("nama", "asc")
            ->where('parent_id', $kecamatan_id)
            ->get();
        return response()->json($data);
    }

    public function getKelurahanDesaImport($kecamatan_id = 0)
    {
        $data['data'] = Wilayah::orderby("nama", "asc")
            ->where('parent_id', $kecamatan_id)
            // ->where('jumlah', NULL)
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

    public function cek_total($kabkota)
    {

        $wilayah = Wilayah::where('kode_kab', $kabkota)->get();
        foreach ($wilayah as $item) {
            $total_dpt = Dpt::where('wilayah_id', $item->id)->count();

            if ($item->jumlah != $total_dpt) {
                $kecamatan = $item->kecamatan->nama;
                echo "Kecamatan :  $kecamatan ,wilayah : $item->nama, total kelurahan desa : $item->jumlah, total dpt : $total_dpt <br>";
            }
        };
    }

    public function update_total_kecamatan()
    {

        $kecamatan = Kecamatan::all();
        foreach ($kecamatan as $item) {

            $total = Dpt::where('kecamatan', $item->id)->count();

            $total__PB = Dpt::where('usia', '>=', 78)->where('kecamatan', $item->id)->count();
            $total__BB = Dpt::whereBetween('usia', [59, 77])->where('kecamatan', $item->id)->count();
            $total__X = Dpt::whereBetween('usia', [43, 58])->where('kecamatan', $item->id)->count();
            $total__Y = Dpt::whereBetween('usia', [27, 42])->where('kecamatan', $item->id)->count();
            $total__Z = Dpt::whereBetween('usia', [11, 26])->where('kecamatan', $item->id)->count();

            $data['jumlah'] = $total;
            $data['jumlah_PB'] = $total__PB;
            $data['jumlah_BB'] = $total__BB;
            $data['jumlah_X'] = $total__X;
            $data['jumlah_Y'] = $total__Y;
            $data['jumlah_Z'] = $total__Z;

            Kecamatan::where(
                'id',
                $item->id
            )->update($data);

            echo "kecamatan $item->nama | total : $total, total PB : $total__PB, total BB : $total__BB, total X : $total__X, total Y : $total__Y, total Z : $total__Z ";
            echo "<br>";
        };

        echo "berhasil";
    }

    public function update_total_kabkota()
    {

        $kecamatan = Kabkota::all();
        foreach ($kecamatan as $item) {

            $total = Dpt::where('kabkota', $item->id)->count();

            $total__PB = Dpt::where('usia', '>=', 78)->where('kabkota', $item->id)->count();
            $total__BB = Dpt::whereBetween('usia', [59, 77])->where('kabkota', $item->id)->count();
            $total__X = Dpt::whereBetween('usia', [43, 58])->where('kabkota', $item->id)->count();
            $total__Y = Dpt::whereBetween('usia', [27, 42])->where('kabkota', $item->id)->count();
            $total__Z = Dpt::whereBetween('usia', [11, 26])->where('kabkota', $item->id)->count();

            $data['jumlah'] = $total;
            $data['jumlah_PB'] = $total__PB;
            $data['jumlah_BB'] = $total__BB;
            $data['jumlah_X'] = $total__X;
            $data['jumlah_Y'] = $total__Y;
            $data['jumlah_Z'] = $total__Z;

            kabkota::where(
                'id',
                $item->id
            )->update($data);

            echo "Kabkota $item->nama | total : $total, total PB : $total__PB, total BB : $total__BB, total X : $total__X, total Y : $total__Y, total Z : $total__Z ";
            echo "<br>";
        };
        echo "berhasil";
    }
}
