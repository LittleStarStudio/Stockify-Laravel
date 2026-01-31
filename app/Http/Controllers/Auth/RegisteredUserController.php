<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    // Menapilkan halaman register
    public function create(): View
    {
        return view('auth.register');
    }

    // Menangani proses register user baru
    public function store(Request $request): RedirectResponse
    {
        // Validai input register
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'string',
                'lowercase',
                'email',
                'max:255',
                'unique:users,email',
            ],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        // Membuat user baru
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'staff_gudang',
            'approval_status' => 'pending',
        ]);

        // Event untuk register
        event(new Registered($user));

        // Redirect ke halaman login
        return redirect()->route('login')->with(
            'status',
            'Registrasi berhasil. Silakan tunggu persetujuan admin.'
        );
    }
}
