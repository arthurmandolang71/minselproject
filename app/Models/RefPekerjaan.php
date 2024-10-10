<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class RefPekerjaan extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'ref_pekerjaan';
    protected $primaryKey = 'id';
    protected $guarded = ['id'];
}
