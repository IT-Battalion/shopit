<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Icon extends Model
{
    use HasFactory;

    protected $table = 'icons';

    protected $fillable = [
        'original_id',
        'name',
        'artist',
        'provider',
        'license',
        'mimetype',
        'path',
    ];

    public function product_categories(): HasMany
    {
        return $this->hasMany(ProductCategory::class, 'icon_id');
    }
}
