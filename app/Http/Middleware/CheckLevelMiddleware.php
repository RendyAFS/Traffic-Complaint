<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckLevelMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string  $level
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function handle(Request $request, Closure $next, $level): Response
    {
        // Cek apakah user yang login memiliki level yang sesuai
        if (Auth::check() && Auth::user()->level == $level) {
            return $next($request);
        }

        // Simpan pesan error dalam session dan redirect back
        return redirect()->back()->with('status', 'error')->with('message', 'Anda tidak memiliki akses untuk halaman ini.');
    }
}
