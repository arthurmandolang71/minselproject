<?php

namespace App\Models;

use App\Models\CalegPendukung;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Provinsi extends Model
{
    use HasFactory;

    protected $table = 'provinsi';
    protected $primaryKey = 'id';
    protected $guarded = ['id'];

    public function pendukung_caleg(): HasMany
    {
        return $this->hasMany(CalegPendukung::class, 'prov', 'id');
    }
}
