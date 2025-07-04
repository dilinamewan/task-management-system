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
            
            return view('admin.dashboard', compact(
                'totalTasks', 'totalUsers', 'pendingTasks', 'completedTasks', 'recentTasks'
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
}