<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class HighlightedProduct extends Model
{
    use HasFactory;

    protected $table = 'highlighted_products';

    protected $fillable = [
        'product_id'
    ];

    protected $casts = [];

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
}
