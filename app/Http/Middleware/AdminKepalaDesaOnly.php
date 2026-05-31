<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AdminKepalaDesaOnly
{
    public function handle(Request $request, Closure $next): Response
    {
        if (! Auth::check()) {
            abort(403, 'Akses hanya untuk Admin Kepala Desa.');
        }

        /** @var User|null $user */
        $user = Auth::user();

        if (! $user || ! $user->isAdminKepalaDesa() || $user->status !== 'active') {
            abort(403, 'Akses hanya untuk Admin Kepala Desa.');
        }

        if (! $user->desa) {
            abort(403, 'Akun Kepala Desa belum memiliki wilayah desa.');
        }

        return $next($request);
    }
}
