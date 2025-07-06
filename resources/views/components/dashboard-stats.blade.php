@props(['userId' => null])

@php
    $dashboardService = app(\App\Services\DashboardService::class);
    $taskStats = $dashboardService->getTaskStatistics($userId);
    $recentTasks = $dashboardService->getRecentTasks($userId);
@endphp

<div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
    <!-- Task Statistics Cards -->
    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex items-center">
            <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                <i class="fas fa-tasks text-blue-600 text-xl"></i>
            </div>
            <div class="ml-4">
                <h3 class="text-sm font-medium text-gray-500">Total Tasks</h3>
                <p class="text-2xl font-bold text-gray-900">{{ $taskStats['total'] }}</p>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex items-center">
            <div class="w-12 h-12 bg-yellow-100 rounded-lg flex items-center justify-center">
                <i class="fas fa-clock text-yellow-600 text-xl"></i>
            </div>
            <div class="ml-4">
                <h3 class="text-sm font-medium text-gray-500">Pending</h3>
                <p class="text-2xl font-bold text-gray-900">{{ $taskStats['pending'] }}</p>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex items-center">
            <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                <i class="fas fa-spinner text-blue-600 text-xl"></i>
            </div>
            <div class="ml-4">
                <h3 class="text-sm font-medium text-gray-500">In Progress</h3>
                <p class="text-2xl font-bold text-gray-900">{{ $taskStats['in_progress'] }}</p>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex items-center">
            <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                <i class="fas fa-check text-green-600 text-xl"></i>
            </div>
            <div class="ml-4">
                <h3 class="text-sm font-medium text-gray-500">Completed</h3>
                <p class="text-2xl font-bold text-gray-900">{{ $taskStats['completed'] }}</p>
            </div>
        </div>
    </div>
</div>

@if($taskStats['overdue'] > 0)
    <div class="bg-red-50 border border-red-200 rounded-lg p-4 mb-6">
        <div class="flex items-center">
            <i class="fas fa-exclamation-triangle text-red-500 mr-3"></i>
            <div>
                <h3 class="text-sm font-medium text-red-800">
                    {{ $taskStats['overdue'] }} {{ Str::plural('task', $taskStats['overdue']) }} overdue
                </h3>
                <p class="text-sm text-red-700 mt-1">
                    Please review and update these tasks as soon as possible.
                </p>
            </div>
        </div>
    </div>
@endif

<!-- Recent Tasks -->
@if($recentTasks->count() > 0)
    <x-card title="Recent Tasks" icon="fas fa-history">
        <div class="space-y-3">
            @foreach($recentTasks as $task)
                <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                    <div class="flex items-center space-x-3">
                        <div class="w-8 h-8 bg-gradient-to-br from-blue-500 to-blue-600 rounded-lg flex items-center justify-center text-white text-xs font-medium">
                            {{ strtoupper(substr($task->title, 0, 2)) }}
                        </div>
                        <div>
                            <h4 class="text-sm font-medium text-gray-900">{{ $task->title }}</h4>
                            <p class="text-xs text-gray-500">{{ $task->user->name }} • {{ $task->created_at->diffForHumans() }}</p>
                        </div>
                    </div>
                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium
                        @if($task->status == 'pending') bg-yellow-100 text-yellow-800
                        @elseif($task->status == 'in_progress') bg-blue-100 text-blue-800
                        @elseif($task->status == 'completed') bg-green-100 text-green-800
                        @endif">
                        {{ ucfirst(str_replace('_', ' ', $task->status)) }}
                    </span>
                </div>
            @endforeach
        </div>
    </x-card>
@endif
