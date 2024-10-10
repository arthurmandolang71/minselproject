<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class KlasifikasiBantuan extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'klasifikasi_bantuan';
    protected $fillable = [];
    protected $guarded = ['id'];
}
