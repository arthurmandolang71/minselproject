<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Kabkota extends Model
{
    use HasFactory;

    protected $table = 'kabkota';
    protected $primaryKey = 'id';
    protected $guarded = ['id'];

    public function pendukung_caleg(): HasMany
    {
        return $this->hasMany(CalegPendukung::class, 'kabkota', 'id');
    }

    public function sk(): HasOne
    {
        return $this->hasOne(SkStruktur::class, 'kabkota', 'id');
    }
}
