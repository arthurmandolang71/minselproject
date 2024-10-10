<?php

namespace App\Models;

use GuzzleHttp\Psr7\Request;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Dpt extends Model
{

    use HasFactory, HasUuids;

    protected $table = 'dpt';
    protected $primaryKey = 'id';
    protected $guarded = ['id'];
    // protected $with = ['kabkota_ref'];

    public function scopeCari($query, array $filters)
    {
        $level_caleg = session()->get('level_caleg');
        $dapil_kabkota = session()->get('kabkota_dapil');
        $dapil_kecamatan = session()->get('kecamatan_dapil');

        //kabkota filter
        // jika caleg daeraj

        if ($level_caleg > 1) {

            if (isset($filters['kabkota'])) {
                $kabkota = [$filters['kabkota']];
            } else {
                $kabkota = $dapil_kabkota;
            }

            $query->when(
                $kabkota,
                fn($query, $kabkota) =>
                $query->where('kabkota', $kabkota)
            );
        }
        // jika dpr ri
        else {
            $kabkota = $filters['kabkota'] ?? false;
            $query->when(
                $kabkota,
                fn($query, $kabkota) =>
                $query->where('kabkota', $kabkota)
            );
        }

        //kecamatan filter
        // jika caleg daeraj
        if ($level_caleg == 3) {

            if (isset($filters['kecamatan'])) {
                $kecamatan = [$filters['kecamatan']];
            } else {
                $kecamatan = $dapil_kecamatan;
            }

            $query->when(
                $kecamatan,
                fn($query, $kecamatan) =>
                $query->whereIn('kecamatan', $kecamatan)
            );
        }
        // jika dpr ri
        else {
            $kecamatan = $filters['kecamatan'] ?? false;
            $query->when(
                $kecamatan,
                fn($query, $kecamatan) =>
                $query->where('kecamatan', $kecamatan)
            );
        }


        $kelurahandesa = $filters['kelurahandesa'] ?? false;
        $query->when(
            $kelurahandesa,
            fn($query, $kelurahandesa) =>
            $query->where('kelurahan_desa', $kelurahandesa)
        );

        $tps = $filters['tps'] ?? false;
        if ($tps) {
            $tps_string = sprintf('%03d', $filters['tps']) ?? false;
        } else {
            $tps_string = NULL;
        }

        $query->when(
            $tps_string,
            fn($query, $tps_string) =>
            $query->where('tps', $tps_string)
        );

        $nama = $filters['cari_nama'] ?? false;
        $query->when(
            $nama,
            fn($query, $nama) =>
            $query->where('nama', 'like', "%$nama%")
        );
    }

    public function kabkota_ref(): HasOne
    {
        return $this->hasOne(Kabkota::class, 'id', 'kabkota');
    }

    public function kecamatan_ref(): HasOne
    {
        return $this->hasOne(Kecamatan::class, 'id', 'kecamatan');
    }

    public function kelurahandesa_ref(): HasOne
    {
        return $this->hasOne(Wilayah::class, 'id', 'kelurahan_desa');
    }

    public function pendukung(): HasOne
    {
        return $this->hasOne(CalegPendukung::class, 'dpt', 'id');
    }

    // public function pendukung(): HasOne
    // {
    //     return $this->hasOne(CalegPendukung::class, 'dpt', 'id');
    // }
}
