<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Tim extends Model
{
    use HasFactory, HasUuids;
    protected $table = 'tim';
    protected $fillable = [];
    protected $guarded = ['id'];
}
