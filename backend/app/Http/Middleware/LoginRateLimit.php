<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;

class LoginRateLimit
{
    public function handle(Request $request, Closure $next)
    {
        $key = 'login-attempts:' . $request->ip();

        if (RateLimiter::tooManyAttempts($key, 5)) {
            return response()->json(['message' => 'Muitas tentativas. Tente novamente mais tarde.'], 429);
        }

        RateLimiter::hit($key, 60); // decay 60 seconds

        $response = $next($request);

        // If login failed (status 401), keep the hit; if succeeded, clear attempts
        if ($response->getStatusCode() === 200) {
            RateLimiter::clear($key);
        }

        return $response;
    }
}
