<?php

namespace App\Http\Middleware;

use App\Helpers\Api;
use Closure;
use Illuminate\Http\Request;

class CheckRole
{
    public function handle(Request $request, Closure $next, string ...$roles): mixed
    {
        $user = $request->user();

        if (!$user) {
            return Api::unauthorized();
        }

        // 1 round-trip — eager load semua relasi role sekaligus
        $user->loadMissing(['admin', 'teacher', 'student']);

        $userRole = $user->getRole();

        if ($userRole === 'unknown') {
            return Api::forbidden('Akun belum memiliki role.');
        }

        if (!in_array($userRole, $roles)) {
            return Api::forbidden('Anda tidak memiliki akses ke resource ini.');
        }

        return $next($request);
    }
}
