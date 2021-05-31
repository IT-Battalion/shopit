<?php

namespace App\Models;

use App\Traits\UuidKeyAndTrackInteractionUsers;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use UuidKeyAndTrackInteractionUsers;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'description',
        'thumbnail',
        'price',
        'sale',
        'available',
    ];

    protected $attributeTypeNames = [
        'clothing' => 'Kleidungsgröße',
        'weight' => 'Gewicht',
        'volume' => 'Volumen',
    ];

    public function thumbnail()
    {
        return $this->hasOne('App\\Models\\ProductImage', 'id', 'thumbnail');
    }

    public function created_by()
    {
        return $this->hasOne('App\\Models\\User', 'id', 'created_by');
    }

    public function updated_by()
    {
        return $this->hasOne('App\\Models\\User', 'id', 'updated_by');
    }

    public function images()
    {
        return $this->belongsToMany('App\\Models\\ProductImage');
    }

    public function category()
    {
        return $this->belongsTo('App\\Models\\ProductCategory', 'product_category_id', 'id');
    }

    public function getProductAttribute()
    {
        return $this->attribute_value .
        (( $this->attribute_type && !in_array( $this->attribute_type, [ __('clothing') ] )) ?
        $this->attribute_unit : '');
    }

    public function getProductAttributeType()
    {
        return $this->attributeTypeNames[$this->attribute_type];
    }
}
