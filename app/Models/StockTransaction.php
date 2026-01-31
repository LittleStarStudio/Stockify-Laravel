<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class StockTransaction extends Model
{
    use SoftDeletes;
    
    protected $fillable = [
        'product_id',
        'user_id',
        'approved_by',
        'type',
        'quantity',
        'date',
        'status',
        'notes',
        'system_stock',
        'physical_stock',
        'source',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function approver()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

}
