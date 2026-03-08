<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class ProdiMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        // Pastikan user adalah dosen DAN statusnya adalah admin (Prodi)
        if (Auth::guard('dosen')->check() && Auth::guard('dosen')->user()->is_admin === 'YES') {
            return $next($request);
        }

        // Jika dia dosen biasa (bukan prodi), tendang ke dashboard dosen biasa
        abort(403, 'Akses Ditolak. Halaman ini khusus untuk Prodi.');
    }
}