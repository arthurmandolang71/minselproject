<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class TimReferensi extends Model
{
    use HasFactory, HasUuids;
    protected $table = 'tim_referensi';
    protected $fillable = [];
    protected $guarded = ['id'];

    public function tim_ref(): HasOne
    {
        return $this->hasOne(Tim::class, 'id', 'tim_id');
    }

    public function user_ref(): HasOne
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    public function pengikut_ref(): HasMany
    {
        $level_caleg = session()->get('level_caleg');

        if ($level_caleg == 1) {
            return $this->hasMany(CalegPendukungRi::class, 'referensi_id', 'id');
        } elseif ($level_caleg == 2) {
            return $this->hasMany(CalegPendukungProv::class, 'referensi_id', 'id');
        } elseif ($level_caleg == 3) {
            return $this->hasMany(CalegPendukungKabkota::class, 'referensi_id', 'id');
        }
    }
}
