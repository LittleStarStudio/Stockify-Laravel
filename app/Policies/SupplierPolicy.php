<?php

namespace App\Policies;

use App\Models\Supplier;
use App\Models\User;

class SupplierPolicy
{
    // View list data supplier
    public function viewAny(User $user): bool
    {
        return $user->role === 'admin' || $user->role === 'manajer_gudang';
    }

    // View detail data supplier
    public function view(User $user, Supplier $supplier): bool
    {
        return $user->role === 'admin' || $user->role === 'manajer_gudang';
    }

    // Create new supplier
    public function create(User $user): bool
    {
        return $user->role === 'admin';
    }

    // Update supplier
    public function update(User $user, Supplier $supplier): bool
    {
        return $user->role === 'admin';
    }

   // Delete supplier (soft delete)
    public function delete(User $user, Supplier $supplier): bool
    {
        return $user->role === 'admin';
    }

    // Restore supplier (dari soft delete)
    public function restore(User $user, Supplier $supplier): bool
    {
        return $user->role === 'admin';
    }

}
