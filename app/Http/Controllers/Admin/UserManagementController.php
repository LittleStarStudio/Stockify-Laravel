<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;

class UserManagementController extends Controller
{

    //Menampilkan semua daftar user (kecuali admin)
    public function index()
    {
        $users = User::withTrashed()
            ->where('approval_status', '!=', 'pending')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('admin.users-management.index', compact('users'));
    }


    // Membuat data user baru (oleh admin)
    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|min:6',
            'role'     => 'required|in:manajer_gudang,staff_gudang',
        ]);

        // Memasukkan input ke database
        User::create([
            'name'            => $request->name,
            'email'           => $request->email,
            'password'        => Hash::make($request->password),
            'role'            => $request->role,
            'approval_status' => 'active', // admin create = langsung aktif
        ]);

        return back()->with('success', 'User berhasil ditambahkan.');
    }

    // Mengupdate data user (oleh admin)
    public function update(Request $request, User $user)
    {
        // Proteksi jika bukan admin
        if ($user->role === 'admin') {
            abort(403);
        }

        // Validasi input
        $request->validate([
            'name'  => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'role'  => 'required|in:manajer_gudang,staff_gudang',
            'password' => 'nullable|min:6',
        ]);

        $data = $request->only('name', 'email', 'role');

        // Jika admin membuatkan password baru
        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        // Memasukkan input ke database
        $user->update($data);

        return back()->with('success', 'User berhasil diperbarui.');
    }

    // Menghapus data user (oleh admin + soft delete)
    public function destroy(User $user)
    {
        // Proteksi jika bukan admin
        if ($user->role === 'admin') {
            abort(403);
        }

        // Hapus data (Soft delete)
        $user->delete();

        return back()->with('success', 'User berhasil dihapus.');
    }

    // Merestore data user yang dihapus (dari soft delete)
    public function restore($id)
    {
        // Cari user termasuk yang di soft delete
        $user = User::withTrashed()->findOrFail($id);

        // Proteksi jika bukan admin
        if ($user->role === 'admin') {
            abort(403);
        }

        // Restore data user
        $user->restore();

        return back()->with('success', 'User berhasil direstore.');
    }
}
