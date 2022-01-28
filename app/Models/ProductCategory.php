<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use JetBrains\PhpStorm\ArrayShape;

class ProductCategory extends Model
{
    use HasFactory;

    protected $table = 'product_categories';

    protected $fillable = [
        'name',
        'icon_id',
    ];

    protected $casts = [];

    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }

//    public function icon(): BelongsTo
//    {
//        return $this->belongsTo(Icon::class);
//    }

    #[ArrayShape(['id' => "int", 'name' => "string", 'icon' => "int[]"])]
    public function jsonSerialize(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'icon' => [
                'id' => $this->icon_id,
            ],
        ];
    }
}
