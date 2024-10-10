<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class RefAgama extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'ref_agama';
    protected $primaryKey = 'id';
    protected $guarded = ['id'];
}
