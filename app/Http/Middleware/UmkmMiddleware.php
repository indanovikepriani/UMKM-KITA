<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class UmkmMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check() && Auth::user()->role === 'umkm') {
            return $next($request);
        }

        return redirect('/')->with('error', 'Akses ditolak! Anda bukan Mitra UMKM.');
    }
}
