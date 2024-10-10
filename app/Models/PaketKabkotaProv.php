<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PaketKabkotaProv extends Model
{
    use HasFactory, HasUuids;
    protected $table = 'paket_kabkota_prov';
    protected $fillable = [];
    protected $guarded = ['id'];

    public function caleg_kabkota_ref(): HasMany
    {
        return $this->hasMany(CalegKabkota::class, 'id', 'caleg_kabkota');
    }

    public function caleg_prov_ref(): HasMany
    {
        return $this->hasMany(CalegProv::class, 'id', 'caleg_prov');
    }
}
