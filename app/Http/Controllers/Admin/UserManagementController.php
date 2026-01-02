<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UserManagementController extends Controller
{

    // --- Menampilakan data user di halaman Users Management ---
    public function index() {

        // Menampilkan users yang active dan rejected saja (users pending tidak dimasukkan)
        $users = User::where('approval_status', '!=', 'pending')
            ->whereNull('deleted_at')
            ->orderBy('created_at', 'desc')
            ->get();

        // Menampilakan users yang telah di deleted saja menggunakan soft delete (khusus untuk nanti di modal Bin)
        $trashedUsers = User::onlyTrashed()
            ->orderBy('deleted_at', 'desc')
            ->get();

        return view('admin.users-management.index', compact('users', 'trashedUsers'));
    }


    // --- Membuat user baru ---
    public function store(Request $request) {

        // Validasi request data baru yang akan dibuat
        $request->validate([
            'name'     => ['required', 'string', 'max:255'],
            'email'    => ['required', 'email', 'unique:users,email'],
            'password' => ['required', 'min:6'],
            'role'     => ['required', Rule::in(['admin', 'manajer_gudang', 'staff_gudang'])],
            'avatar'   => ['nullable', 'image', 'max:2048'],
        ]);

        // Untuk avatar users secara default kondisi awalnya akan null
        $avatarPath = null;

        // Dan jika users mau memasukkan foto avatarnya, maka baru akan kita simpankan
        if ($request->hasFile('avatar')) {
            $avatarPath = $request->file('avatar')->store('avatars', 'public');
        }

        // Kemudian baru terakhir kita buat dan masukkan semua data yang direquest
        User::create([
            'name'            => $request->name,
            'email'           => $request->email,
            'password'        => Hash::make($request->password),
            'role'            => $request->role,
            'avatar'          => $avatarPath,
            'approval_status' => 'active' // Langsung active karena dibuat langsung oleh admin
        ]);

        return back()->with('success', 'User berhasil ditambahkan');
    }


    // --- Update data user ---
    public function update(Request $request, User $user) {

        // Admin tidak boleh di edit
        if ($user->role === 'admin') {
            abort(403);
        }

        // Validasi request untuk edit data
        $request->validate([
            'name'  => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'email',
                Rule::unique('users', 'email')->ignore($user->id),
            ],
            'role'     => ['required', Rule::in(['admin', 'manajer_gudang', 'staff_gudang'])],
            'password' => ['nullable', 'min:6'],
            'avatar'   => ['nullable', 'image', 'max:2048'],
        ]);

        // Data data yang akan langsung dimasukkan secara default jika collum password dan avatar tidak di isi (karena opsional)
        $data = $request->only('name', 'email', 'role');

        // Jika menambahkan update password juga maka akan ditambahkan juga
        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        // Jika menambahkan update foto avatar juga maka akan ditambahkan juga
        if ($request->hasFile('avatar')) {
            $data['avatar'] = $request->file('avatar')->store('avatars', 'public');
        }

        // Baru kita masukkan update data nya user
        $user->update($data);

        return back()->with('success', 'User berhasil diperbarui');
    }


    // --- Delete data user (soft delete) ---
    public function destroy(User $user) {

        // Validasi dan dicek dulu aksi delete yang akan dilakukan

        // Admin tidak boleh hapus data admin lain
        if ($user->role === 'admin') {
            abort(403);
        }

        // Tidak boleh hapus data diri sendiri (Admin => hapus datanya sendiri)
        if (auth()->id() === $user->id) {
            return back()->with('error', 'Anda tidak bisa menghapus akun diri sendiri');
        }

        // Jika sudah aman
        // Baru bisa delete data user
        $user->delete();

        return back()->with('success', 'User berhasil dihapus');
    }


    // --- Restore data user (dari soft delete di bin) ---
    public function restore($id) {

        // Ambil semua data user yang di soft delete
        $user = User::onlyTrashed()->findOrFail($id);

        // Tidak boleh restore admin
        if ($user->role === 'admin') {
            abort(403);
        }

        // Baru bisa restore data yang di soft delete tadi
        $user->restore();

        return back()->with('success', 'User berhasil direstore');
    }


}
