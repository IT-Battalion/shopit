<?php

namespace App\Models;

use App\Contracts\ConvertableToOrder;
use App\Traits\TracksModification;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;

class ProductImage extends Model implements ConvertableToOrder
{
    use HasFactory, TracksModification;

    protected $table = 'product_images';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'path',
        'type',
        'product_id',
    ];

    protected $casts = [];

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }

    public function getOrderEquivalent(array $attributes = [])
    {
        $orderProductImage = $this->findOrderEquivalent();

        if (isset($orderProductImage)) {
            return $orderProductImage;
        }

        $hash = hash_file('sha256', Storage::path($this->path));
        $orderPath = Storage::path('order/product/images/' . $hash . time() . pathinfo($this->path, PATHINFO_EXTENSION));
        Storage::copy($this->path, $orderPath);

        return OrderProductImage::create([
            'path' => $orderPath,
            'type' => $this->type,
            'hash' => $hash,
        ]);
    }

    public function findOrderEquivalent()
    {
        $hash = hash_file('sha256', Storage::path($this->path));

        return OrderProductImage::whereHash($hash);
    }
}
