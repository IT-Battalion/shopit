<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class document extends Model
{
    use HasFactory;

    protected $table = 'documents';

    protected $fillable = [
        'text_type',
        'text_raw'
    ];

    protected $casts = [
        'text_type' => 'string',
        'text_raw' => 'string'
    ];


}
