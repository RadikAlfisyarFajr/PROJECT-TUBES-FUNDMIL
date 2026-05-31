<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminInstansiOnly
{
    public function handle(Request $request, Closure $next): Response
    {
        if (! Auth::check()) {
            abort(403, 'Akses hanya untuk Admin Instansi.');
        }

        /** @var User|null $user */
        $user = Auth::user();

        if (! $user || ! $user->isAdminInstansi() || $user->status !== 'active') {
            abort(403, 'Akses hanya untuk Admin Instansi.');
        }

        if (! $user->instansi || $user->instansi->status !== 'aktif') {
            abort(403, 'Instansi belum aktif atau sudah dinonaktifkan.');
        }

        return $next($request);
    }
}
