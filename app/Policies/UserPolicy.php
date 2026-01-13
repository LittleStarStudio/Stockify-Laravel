<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\Response;

class UserPolicy
{
    
    // Admin boleh melihat list user
    public function viewAny(User $auth): bool
    {
        return $auth->role === 'admin';
    }

    // Admin boleh melihat detail user
    public function view(User $auth, User $user): bool
    {
        return $auth->role === 'admin';
    }

    // Admin boleh membuat user baru
    public function create(User $auth): bool
    {
        return $auth->role === 'admin';
    }

    // Admin boleh mengupdate user (termasuk admin lain)
    public function update(User $auth, User $user): bool
    {
        return $auth->role === 'admin';
    }

    // Admin boleh menghapus user (tapi tidak boleh menghapus diri sendiri)
    public function delete(User $auth, User $user): bool
    {
        if ($auth->id === $user->id) {
            return false;
        }

        return $auth->role === 'admin';
    }

    // Admin boleh mengembalikan user yang dihapus
    public function restore(User $auth, User $user): bool
    {
        return $auth->role === 'admin';
    }

}
