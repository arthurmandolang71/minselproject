<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CalegPendukungKabkota extends Model
{
    use HasFactory, HasUuids;
    protected $table = 'caleg_pendukung_kabkota';
    protected $fillable = [];
    protected $guarded = ['id'];
    protected $with = ['pendukung_ref'];

    public function scopeCari($query, array $filters)
    {

        $caleg_id = session()->get('caleg_id');

        //kabkota filter
        // jika caleg daerah

        $query->where('celeg_id', $caleg_id);

        $kabkota = $filters['kabkota'] ?? false;
        $query->when(
            $kabkota,
            fn ($query, $kabkota) =>
            $query->whereHas('pendukung_ref', fn ($query) =>
            $query->where('kabkota', $kabkota))
        );

        $kecamatan = $filters['kecamatan'] ?? false;
        $query->when(
            $kecamatan,
            fn ($query, $kecamatan) =>
            $query->whereHas('pendukung_ref', fn ($query) =>
            $query->where('kecamatan', $kecamatan))
            // $query->where('kecamatan', $kecamatan)
        );


        $kelurahandesa = $filters['kelurahandesa'] ?? false;
        $query->when(
            $kelurahandesa,
            fn ($query, $kelurahandesa) =>
            $query->whereHas('pendukung_ref', fn ($query) =>
            $query->where('kelurahan_desa', $kelurahandesa))
        );

        $tps = $filters['tps'] ?? false;
        if ($tps) {
            $tps_string = sprintf('%03d', $filters['tps']) ?? false;
        } else {
            $tps_string = NULL;
        }

        $query->when(
            $tps_string,
            fn ($query, $tps_string) =>
            $query->whereHas('pendukung_ref', fn ($query) =>
            $query->where('tps', $tps_string))
        );

        $nama = $filters['cari_nama'] ?? false;
        $query->when(
            $nama,
            fn ($query, $nama) =>
            $query->whereHas(
                'pendukung_ref',
                fn ($query) =>
                $query->where('nama', 'like', "%$nama%")
            )
        );

        $referensi = $filters['referensi'] ?? false;
        $query->when(
            $referensi,
            fn ($query, $referensi) =>
            $query->where('referensi_id', $referensi)
        );

        $klasifikasi = $filters['klasifikasi'] ?? false;
        $query->when(
            $klasifikasi,
            fn ($query, $klasifikasi) =>
            $query->where('klasifikasi_id', $klasifikasi)
        );

        $klasifikasi_bantuan = $filters['klasifikasi_bantuan'] ?? false;
        $query->when(
            $klasifikasi_bantuan,
            fn ($query, $klasifikasi_bantuan) =>
            $query->where('klasifikasi_bantuan_id', $klasifikasi_bantuan)
        );
    }

    public function pendukung_ref(): HasOne
    {
        return $this->hasOne(CalegPendukung::class, 'dpt', 'dpt')->orderBy('tps', 'desc');
    }

    public function klasifikasi_ref(): HasOne
    {
        return $this->hasOne(KlasifikasiPendukung::class, 'id', 'klasifikasi_id');
    }

    public function bantuan_ref(): HasOne
    {
        return $this->hasOne(KlasifikasiBantuan::class, 'id', 'klasifikasi_bantuan_id');
    }
    public function relawan_ref(): HasOne
    {
        return $this->hasOne(TimReferensi::class, 'id', 'referensi_id');
    }
}
