<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class 34 extends Model {
    use HasFactory;

    protected $table = '34';
    protected $fillable = {json_encode(array_keys(Array))};
    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];
}