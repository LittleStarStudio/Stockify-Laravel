<?php

namespace App\Http\Controllers\Admin;


use App\Models\User;
use App\Http\Controllers\Controller;
use App\Http\Requests\UserUpdateRequest;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\Request;

class UserManagementController extends Controller
{

    // --- Menampilakan data user di halaman Users Management ---
    public function index() {

        $users = User::whereNull('deleted_at')
            ->where('approval_status', '!=', 'pending')
            ->latest()
            ->get();

            
        return view('admin.users-management.index', [
            'users'=> $users,
            'isTrash' => false
        ]);
    }


    // --- Membuat user baru ---
    public function store(Request $request){

        // Authorisasi akses create data user
        $this->authorize('create', User::class);

        try {

            // Validasi data inputan
            $validated = $request->validate([
                'name'     => ['required', 'string', 'max:255'],
                'email'    => ['required', 'email', 'unique:users,email'],
                'password' => ['required', 'min:6'],
                'role'     => ['required', Rule::in(['admin','manajer_gudang','staff_gudang'])],
                'avatar'   => ['nullable', 'image', 'max:2048'],
            ]);

        } catch (ValidationException $e) {

            // Kembalikan response error jika validasi gagal
            return response()->json([
                'message' => 'Validation error',
                'errors'  => $e->errors()
            ], 422);
        }

        // Simpan avatar jika ada
        $avatarPath = null;

        if ($request->hasFile('avatar')) {
            $avatarPath = $request->file('avatar')->store('avatars', 'public');
        }

        // Buat user baru dengan data yang sudah tervalidasi
        User::create([
            'name'            => $validated['name'],
            'email'           => $validated['email'],
            'password'        => Hash::make($validated['password']),
            'role'            => $validated['role'],
            'avatar'          => $avatarPath,
            'approval_status' => 'active',
        ]);

        // Berikan notifikasi sukses
        return response()->json([
            'message' => 'User created successfully.'
        ]);
    }



    // --- Update data user ---
    public function update(UserUpdateRequest $request, User $user) {

        // Authorisasi akses update data user
        $this->authorize('update', $user);

        // Ambil data yang sudah tervalidasi
        $data = $request->validated();

        // Cek apakah ada file avatar yang diupload
        if ($request->hasFile('avatar')) {

            // Hapus avatar lama jika ada
            if ($user->avatar && Storage::disk('public')->exists($user->avatar)) {
                Storage::disk('public')->delete($user->avatar);
            }

            // Simpan avatar baru
            $data['avatar'] = $request->file('avatar')
                ->store('avatars', 'public');
        }

        // Update data user dengan data yang sudah tervalidasi
        $user->update($data);

        // Berikan notifikasi sukses
        return response()->json([
            'message' => 'User updated successfully.'
        ]);
    }


    // --- Delete data user (soft delete) ---
    public function destroy(User $user) {

        // Authorisasi akses delete data user
        $this->authorize('delete', $user);

        // Tidak boleh hapus data diri sendiri (Admin => hapus datanya sendiri)
        if (auth()->id() === $user->id) {
            abort(403, 'You cannot delete your own account.');
        }

        // Jika sudah aman Baru bisa delete data user
        $user->delete();

        // Kembalikan pesan sukses
        return response()->json([
            'message' => 'User deleted successfully.'
        ]);

    }

    // --- Menampilkan data user yang sudah di soft delete (di bin) ---
    public function bin() {
        $users = User::onlyTrashed()->latest()->get();

        return response()->json($users);
    }

    // --- Restore data user (dari soft delete di bin) ---
    public function restore($id) {

        // Ambil user yang disoft delete
        $user = User::onlyTrashed()->findOrFail($id);

        // Authorisasi restore
        $this->authorize('restore', $user);

        // Restore user
        $user->restore();

        return response()->json([
            'message' => 'User restored successfully',
            'user' => [
                'id'    => $user->id,
                'name'  => $user->name,
                'email' => $user->email,
                'role'  => ucfirst(str_replace('_', ' ', $user->role)),
                'status_html' => view('admin.users-management.partials.status', [
                    'user' => $user
                ])->render(),
                'avatar_url' => $user->avatar_url,
            ]
        ]);

    }


}
