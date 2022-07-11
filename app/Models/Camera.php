<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Camera extends Model
{
    use HasFactory;

    protected $table = 'cameras';
    protected $guarded = ['id'];

    protected $casts = ['position' => 'array', 'works' => 'boolean', 'dome' => 'boolean'];
}
