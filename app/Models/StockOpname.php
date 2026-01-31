<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StockOpname extends Model
{
    protected $fillable = [
        'date',
        'status',
        'staff_id',
        'manager_id',
        'notes'
    ];

    // RELATIONS TABLES
    public function items()
    {
        return $this->hasMany(StockOpnameItem::class);
    }

    public function staff()
    {
        return $this->belongsTo(User::class, 'staff_id');
    }

    public function manager()
    {
        return $this->belongsTo(User::class, 'manager_id');
    }
}
