<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Str;

class AssignDeviceToken
{
    public function handle(Request $request, Closure $next)
    {
        if (!$request->hasCookie('device_token')) {

            $token = (string) Str::uuid();

            $response = $next($request);

            return $response->withCookie(
                cookie(
                    'device_token',
                    $token,
                    60 * 24 * 365, // 1 year
                    '/',
                    null,
                    false, // secure (true if HTTPS)
                    false  // httpOnly (true if JS not needed)
                )
            );
        }

        return $next($request);
    }
}
