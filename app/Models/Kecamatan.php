<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Kecamatan extends Model
{
    use HasFactory;

    protected $table = 'kecamatan';
    protected $primaryKey = 'id';
    protected $guarded = ['id'];

    public function pendukung_caleg(): HasMany
    {
        return $this->hasMany(CalegPendukung::class, 'kecamatan', 'id');
    }
}
