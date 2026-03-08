<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, $role): Response
    {
        // Cek apakah user sedang login di guard yang dilempar dari parameter route
        if (!Auth::guard($role)->check()) {
            // Jika belum login atau salah role, lempar kembali ke halaman login
            return redirect('/login')->withErrors([
                'email' => 'Akses ditolak. Silakan login sebagai ' . ucfirst($role) . ' untuk mengakses halaman tersebut.'
            ]);
        }

        return $next($request);
    }
}