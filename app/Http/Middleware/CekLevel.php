<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CekLevel
{
    public function handle(Request $request, Closure $next, string $role): Response
    {
        $user = $request->user();

        if (! $user) {
            return redirect()->route('login');
        }

        $namaLevel = optional($user->level)->nama_level;

        if ($namaLevel !== $role) {
            abort(403, 'Akses ditolak.');
        }

        return $next($request);
    }
}
