<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class SuperAdminOnly
{
    public function handle(Request $request, Closure $next): Response
    {
        if (! Auth::check()) {
            abort(403, 'Akses hanya untuk Super Admin.');
        }

        /** @var User|null $user */
        $user = Auth::user();

        if (! $user || ! $user->isSuperAdmin()) {
            abort(403, 'Akses hanya untuk Super Admin.');
        }

        return $next($request);
    }
}
