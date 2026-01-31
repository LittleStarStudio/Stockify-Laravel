<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckUserApproved
{
    public function handle(Request $request, Closure $next)
    {
        $user = Auth::user();

        // User login
        if ($user instanceof \App\Models\User && ! $user->isActive()) {
            Auth::logout();

            return redirect()->route('login')
                ->with('error', 'Akun Anda belum disetujui atau telah ditolak oleh admin.');
        }

        return $next($request);
    }
}
