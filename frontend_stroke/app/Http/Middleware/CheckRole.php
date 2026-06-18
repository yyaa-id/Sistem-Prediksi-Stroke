<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    public function handle(Request $request, Closure $next, string $role): Response
    {
        // Cek login dan cek apakah role user sama dengan parameter yang diminta
        if (Auth::check() && Auth::user()->role == $role) {
            return $next($request);
        }

        // Kalau bukan admin utama, balikin ke dashboard kasih pesan error
        return redirect('/dashboard')->with('error', 'Akses Ditolak! Halaman ini khusus untuk Admin Utama.');
    }
}