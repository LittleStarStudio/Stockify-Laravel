<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Http\Controllers\Controller;

class UserRequestController extends Controller
{

     // Menampilkan daftar user dengan status pending
    public function index()
    {
        $users = User::where('approval_status', 'pending')
            ->orderBy('created_at', 'asc')
            ->get();

        return view('admin.users-requests.index', compact('users'));
    }

    // Fungsi Approve User
    public function approve(User $user)
    {
        $user->update([
            'approval_status' => 'active',
        ]);

        return redirect()
            ->route('admin.user-requests.index')
            ->with('success', 'User berhasil disetujui.');
    }

    // Fungsi Reject User
    public function reject(User $user)
    {
        $user->update([
            'approval_status' => 'rejected',
        ]);

        return redirect()
            ->route('admin.user-requests.index')
            ->with('warning', 'User berhasil ditolak.');    
    }
}
