<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class 67 extends Model {
    use HasFactory;

    protected $table = '67';
    protected $fillable = {json_encode(array_keys(Array))};
    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];
}