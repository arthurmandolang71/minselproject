<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CalegProv extends Model
{
    use HasFactory, HasUuids;
    protected $table = 'caleg_dapil_prov';
    protected $fillable = [
       
    ];
    protected $guarded = ['id'];

    public function user(): HasOne
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    public function partai(): HasOne
    {
        return $this->hasOne(Partai::class, 'id', 'partai_id');
    }

    public function dapil(): HasOne
    {
        return $this->hasOne(DapilProv::class, 'id', 'dapil_prov');
    }
}
