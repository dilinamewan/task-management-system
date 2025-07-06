<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class TrackUserActivity
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check()) {
            $user = Auth::user();
            $cacheKey = "user_activity_{$user->id}";
            $trackingInterval = config('performance.session.track_activity_interval', 300);
            
            // Only update if not updated recently (to reduce database writes)
            if (!cache()->has($cacheKey)) {
                $user->updateLastActivity();
                
                // Cache for the tracking interval to prevent frequent updates
                cache()->put($cacheKey, true, $trackingInterval);
            }
        }
        
        return $next($request);
    }
}
