<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class PerformanceMonitor
{
    public function handle(Request $request, Closure $next)
    {
        $startTime = microtime(true);
        $startMemory = memory_get_usage();
        
        // Reset query log if enabled
        if (config('app.debug')) {
            DB::flushQueryLog();
            DB::enableQueryLog();
        }
        
        $response = $next($request);
        
        $endTime = microtime(true);
        $endMemory = memory_get_usage();
        
        $executionTime = round(($endTime - $startTime) * 1000, 2); // ms
        $memoryUsed = round(($endMemory - $startMemory) / 1024 / 1024, 2); // MB
        
        // Log slow requests
        if ($executionTime > 1000) { // Log requests slower than 1 second
            $queryCount = config('app.debug') ? count(DB::getQueryLog()) : 0;
            
            Log::warning('Slow request detected', [
                'url' => $request->fullUrl(),
                'method' => $request->method(),
                'execution_time' => $executionTime . 'ms',
                'memory_used' => $memoryUsed . 'MB',
                'query_count' => $queryCount,
                'user_id' => auth()->id(),
            ]);
        }
        
        // Add performance headers for development
        if (config('app.debug')) {
            $response->headers->set('X-Execution-Time', $executionTime . 'ms');
            $response->headers->set('X-Memory-Usage', $memoryUsed . 'MB');
            $response->headers->set('X-Query-Count', count(DB::getQueryLog()));
        }
        
        return $response;
    }
}
