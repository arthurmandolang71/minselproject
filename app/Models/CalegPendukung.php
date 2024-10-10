<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CalegPendukung extends Model
{
    use HasFactory, HasUuids;
    protected $table = 'caleg_pendukung';
    // protected $with = ['caleg_ri', 'caleg_prov', 'caleg_kabkota'];
    protected $guarded = [];


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

    public function pendukung_caleg_ri(): HasOne
    {
        return $this->hasOne(CalegPendukungRi::class, 'dpt', 'dpt');
    }

    public function pendukung_caleg_prov(): HasOne
    {
        return $this->hasOne(CalegPendukungProv::class, 'dpt', 'dpt');
    }

    public function pendukung_caleg_kabkota(): HasOne
    {
        return $this->hasOne(CalegPendukungKabkota::class, 'dpt', 'dpt');
    }
}
