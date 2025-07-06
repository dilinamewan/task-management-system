<?php

namespace App\Services;

use App\Models\Task;
use App\Models\User;
use Illuminate\Support\Facades\Cache;

class DashboardService
{
    public function getTaskStatistics($userId = null, $forceRefresh = false)
    {
        $cacheKey = $userId ? "task_stats_user_{$userId}" : "task_stats_global";
        
        if ($forceRefresh) {
            Cache::forget($cacheKey);
        }
        
        return Cache::remember($cacheKey, now()->addMinutes(15), function () use ($userId) {
            $query = Task::query();
            
            if ($userId) {
                $query->where('user_id', $userId);
            }
            
            return [
                'total' => $query->count(),
                'pending' => $query->clone()->where('status', 'pending')->count(),
                'in_progress' => $query->clone()->where('status', 'in_progress')->count(),
                'completed' => $query->clone()->where('status', 'completed')->count(),
                'overdue' => $query->clone()->overdue()->count(),
                'upcoming' => $query->clone()->upcoming()->count(),
                'high_priority' => $query->clone()->where('priority', 'high')->count(),
            ];
        });
    }
    
    public function getUserStatistics($forceRefresh = false)
    {
        $cacheKey = "user_stats";
        
        if ($forceRefresh) {
            Cache::forget($cacheKey);
        }
        
        return Cache::remember($cacheKey, now()->addMinutes(30), function () {
            return [
                'total_users' => User::count(),
                'active_users' => User::where('last_activity', '>=', now()->subDays(7))->count(),
                'admin_users' => User::where('role', 'admin')->count(),
                'regular_users' => User::where('role', 'user')->count(),
            ];
        });
    }
    
    public function getRecentTasks($userId = null, $limit = 5)
    {
        $cacheKey = $userId ? "recent_tasks_user_{$userId}" : "recent_tasks_global";
        
        return Cache::remember($cacheKey, now()->addMinutes(10), function () use ($userId, $limit) {
            $query = Task::with(['user:id,name'])
                        ->select(['id', 'title', 'status', 'priority', 'due_date', 'user_id', 'created_at'])
                        ->latest();
            
            if ($userId) {
                $query->where('user_id', $userId);
            }
            
            return $query->limit($limit)->get();
        });
    }
    
    public function clearUserCache($userId)
    {
        Cache::forget("task_stats_user_{$userId}");
        Cache::forget("recent_tasks_user_{$userId}");
    }
    
    public function clearGlobalCache()
    {
        Cache::forget("task_stats_global");
        Cache::forget("recent_tasks_global");
        Cache::forget("user_stats");
    }
}
