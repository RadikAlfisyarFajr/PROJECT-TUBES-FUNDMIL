<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminInstansiOnly
{
    public function handle(Request $request, Closure $next): Response
    {
        if (! auth()->check()) {
            abort(403, 'Akses hanya untuk Admin Instansi.');
        }

        if (! auth()->user()->isAdminInstansi()) {
            abort(403, 'Akses hanya untuk Admin Instansi.');
        }

        return $next($request);
    }
}
