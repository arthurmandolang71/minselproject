<?php

namespace App\Models;

use App\Models\CalegPendukung;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Tps extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'tps';
    protected $primaryKey = 'id';
    protected $guarded = ['id'];

    public function pendukung_caleg(): HasMany
    {
        return $this->hasMany(CalegPendukung::class, 'nama', 'tps');
    }
}
