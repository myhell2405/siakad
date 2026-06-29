<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, ...$roles)
    {
        if (! session()->has('role')) {
            return redirect()->route('login');
        }

        $userRole = strtolower(session('role'));
        $userPermissions = session('permissions', []);
        if (! is_array($userPermissions)) {
            $userPermissions = [];
        }

        if ($userRole === 'admin') {
            return $next($request);
        }

        $roles = array_map('strtolower', $roles);

        if (in_array($userRole, $roles)) {
            return $next($request);
        }

        foreach ($roles as $req) {
            if (in_array($req, $userPermissions)) {
                return $next($request);
            }
        }

        abort(403, 'Akses ditolak');
    }
}
