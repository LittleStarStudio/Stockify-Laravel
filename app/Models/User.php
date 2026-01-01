<?php

namespace App\Models;

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

    // Approval helpers
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
}
