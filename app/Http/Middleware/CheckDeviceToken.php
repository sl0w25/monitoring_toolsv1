<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;
use App\Models\AllowedDevice;

class CheckDeviceToken
{
public function handle(Request $request, Closure $next): Response
{
    // Get token FIRST
    $token = $request->header('X-Device-Token')
        ?? $request->cookie('device_token');

    // Debug logs
    Log::info('All request data:', $request->all());
    Log::info('All headers:', $request->headers->all());
    Log::info('All cookies:', $request->cookies->all());
    Log::info('Device token received', ['token' => $token]);

    if (!$token) {
        Log::warning('No device token found');
        return redirect()->route('unauthorized.device');
    }

    $allowed = AllowedDevice::where('device_token', $token)
        ->where('active', true)
        ->exists();

    if (!$allowed) {
        Log::warning('Device not allowed', ['token' => $token]);
        return redirect()->route('unauthorized.device');
    }

    return $next($request);
}

}
