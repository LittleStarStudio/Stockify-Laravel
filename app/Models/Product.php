<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'category_id',
        'supplier_id',
        'name',
        'sku',
        'description',
        'purchase_price',
        'selling_price',
        'image',
        'minimum_stock',
        'is_active',
    ];

    protected $casts = [
        'purchase_price' => 'decimal:2',
        'selling_price'  => 'decimal:2',
        'is_active'      => 'boolean',
    ];

    protected $with = ['attributeValues.attribute'];

    // RELATIONS
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }

    public function stockTransactions()
    {
        return $this->hasMany(StockTransaction::class);
    }

    public function getCurrentStockAttribute()
    {
        $in = $this->stockTransactions()
            ->where('type','IN')
            ->where('status','RECEIVED')
            ->sum('quantity');

        $out = $this->stockTransactions()
            ->where('type','OUT')
            ->where('status','ISSUED')
            ->sum('quantity');

        return $in - $out;
    }

    public function attributeValues()
    {
        return $this->hasMany(ProductAttributeValue::class);
    }

    public function opnameItems()
    {
        return $this->hasMany(StockOpnameItem::class);
    }

    
}

