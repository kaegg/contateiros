<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class RequireAuthenticatedUser
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next)
    {
        $userId = $request->session()->get('user_id');

        if (!$userId) {
            return response()->json(['message' => 'Acesso não autorizado.'], 401);
        }

        return $next($request);
    }
}
