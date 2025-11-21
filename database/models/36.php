<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class 36 extends Model {
    use HasFactory;

    protected $table = '36';
    protected $fillable = {json_encode(array_keys(Array))};
    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];
}