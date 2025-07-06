<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        
        if ($user->isAdmin()) {
            $totalTasks = Task::count();
            $totalUsers = User::where('role', 'user')->count();
            $pendingTasks = Task::where('status', 'pending')->count();
            $completedTasks = Task::where('status', 'completed')->count();
            $recentTasks = Task::with('user')->latest()->limit(5)->get();
            $recentUsers = User::where('role', 'user')->latest()->limit(5)->get();
            
            return view('admin.dashboard', compact(
                'totalTasks', 'totalUsers', 'pendingTasks', 'completedTasks', 'recentTasks', 'recentUsers'
            ));
        } else {
            $myTasks = $user->tasks()->count();
            $pendingTasks = $user->tasks()->where('status', 'pending')->count();
            $completedTasks = $user->tasks()->where('status', 'completed')->count();
            $recentTasks = $user->tasks()->latest()->limit(5)->get();
            
            return view('user.dashboard', compact(
                'myTasks', 'pendingTasks', 'completedTasks', 'recentTasks'
            ));
        }
    }
    
    public function reports()
    {
        // Ensure only admins can access reports
        if (!auth()->user()->isAdmin()) {
            abort(403);
        }
        
        $totalTasks = Task::count();
        $totalUsers = User::count();
        $pendingTasks = Task::where('status', 'pending')->count();
        $inProgressTasks = Task::where('status', 'in_progress')->count();
        $completedTasks = Task::where('status', 'completed')->count();
        
        $tasksByPriority = [
            'low' => Task::where('priority', 'low')->count(),
            'medium' => Task::where('priority', 'medium')->count(),
            'high' => Task::where('priority', 'high')->count(),
        ];
        
        $tasksByUser = User::withCount('tasks')->orderBy('tasks_count', 'desc')->limit(10)->get();
        
        return view('admin.reports', compact(
            'totalTasks', 'totalUsers', 'pendingTasks', 'inProgressTasks', 'completedTasks', 
            'tasksByPriority', 'tasksByUser'
        ));
    }
}