<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;


class KlasifikasiPendukung extends Model
{
    use HasFactory, HasUuids;
    protected $table = 'klasifikasi_pendukung';
    protected $fillable = [];
    protected $guarded = ['id'];
}
