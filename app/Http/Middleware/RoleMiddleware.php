<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * Hanya user dengan role tertentu yang boleh melanjutkan.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next, string $role): Response
    {
        if ($request->user()?->role !== $role) {
            return response()->json([
                'status' => 'error',
                'message' => 'Akses ditolak. Hanya untuk role '.$role.'.',
            ], 403);
        }

        return $next($request);
    }
}
