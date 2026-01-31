<?php

namespace App\Models;

use Illuminate\Support\Facades\Storage;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes;

    protected $fillable = [
        'name',
        'email',
        'password',
        'avatar',
        'role',
        'approval_status',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'password' => 'hashed',
    ];


    // Role helpers
    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function isManajerGudang(): bool
    {
        return $this->role === 'manajer_gudang';
    }

    public function isStaffGudang(): bool
    {
        return $this->role === 'staff_gudang';
    }


    // Status helpers
    public function isActive(): bool
    {
        return $this->approval_status === 'active';
    }

    public function isPending(): bool
    {
        return $this->approval_status === 'pending';
    }

    public function isRejected(): bool
    {
        return $this->approval_status === 'rejected';
    }

    public function isDeleted(): bool
    {
        return $this->trashed();
    }


    // Avatar accessor
    public function getAvatarUrlAttribute(): string
    {
        if ($this->avatar && Storage::disk('public')->exists($this->avatar)) {
            return asset('storage/' . $this->avatar);
        }

        return asset('images/avatar-default.png');
    }

    // RELATION TABLES
    public function stockOpnames()
    {
        return $this->hasMany(StockOpname::class, 'staff_id');
    }

    public function approvedOpnames()
    {
        return $this->hasMany(StockOpname::class, 'manager_id');
    }



}
