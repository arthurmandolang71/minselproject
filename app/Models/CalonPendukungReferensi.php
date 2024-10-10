<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CalonPendukungReferensi extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'calon_pendukung_referensi';
    protected $primaryKey = 'id';
    protected $guarded = ['id'];

    public function relawan_ref(): HasOne
    {
        return $this->hasOne(TimReferensi::class, 'id', 'id_tim');
    }
}
