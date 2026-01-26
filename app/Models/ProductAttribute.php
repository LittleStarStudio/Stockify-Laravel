<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductAttribute extends Model
{
    use SoftDeletes;
    
    protected $fillable = [
        'name',
        'slug'
    ];

    protected $casts = [
        'name' => 'string',
    ];

    public function products()
    {
        return $this->hasManyThrough(
            Product::class,
            ProductAttributeValue::class,
            'attribute_id',
            'id',
            'id',
            'product_id'
        );
    }

    public function values()
    {
        return $this->hasMany(ProductAttributeValue::class, 'attribute_id');
    }


}

