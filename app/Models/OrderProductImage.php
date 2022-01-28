<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class OrderProductImage extends Model
{
    use HasFactory;

    protected $table = 'order_product_images';

    protected $fillable = [
        'path',
        'type',
        'order_product_id',
    ];

    protected $casts = [
        'created_by_id' => 'integer',
        'updated_by_id' => 'integer',
        'order_product_id' => 'integer',
    ];

    public function products(): BelongsToMany
    {
        return $this->belongsToMany(OrderProduct::class);
    }
}
