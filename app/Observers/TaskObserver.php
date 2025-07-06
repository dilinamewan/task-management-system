<?php

namespace App\Observers;

use App\Models\Task;
use App\Services\DashboardService;

class TaskObserver
{
    protected $dashboardService;
    
    public function __construct(DashboardService $dashboardService)
    {
        $this->dashboardService = $dashboardService;
    }
    
    public function created(Task $task)
    {
        $this->clearCaches($task);
    }
    
    public function updated(Task $task)
    {
        $this->clearCaches($task);
        
        // Clear cache for previous user if user was changed
        if ($task->wasChanged('user_id')) {
            $originalUserId = $task->getOriginal('user_id');
            if ($originalUserId) {
                $this->dashboardService->clearUserCache($originalUserId);
            }
        }
    }
    
    public function deleted(Task $task)
    {
        $this->clearCaches($task);
    }
    
    protected function clearCaches(Task $task)
    {
        $this->dashboardService->clearUserCache($task->user_id);
        $this->dashboardService->clearGlobalCache();
    }
}
