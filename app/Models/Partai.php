<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Partai extends Model
{
    use HasFactory, HasUuids;
    protected $table = 'partai';
    // protected $fillable = ['partai_id'];
}
