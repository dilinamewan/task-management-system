<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center space-x-3">
            <div class="w-8 h-8 bg-gradient-to-br from-blue-500 to-blue-600 rounded-lg flex items-center justify-center">
                <i class="fas fa-tachometer-alt text-white text-sm"></i>
            </div>
            <div>
                <h2 class="text-2xl font-bold text-gray-900">Dashboard</h2>
                <p class="text-sm text-gray-500">Welcome back, {{ Auth::user()->name }}!</p>
            </div>
        </div>
    </x-slot>

    <!-- Stats Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
        <x-stat-card 
            label="My Tasks" 
            value="{{ $myTasks }}" 
            icon="fas fa-tasks" 
            color="blue"
            change="+12%" 
            changeType="positive" 
        />
        
        <x-stat-card 
            label="Pending Tasks" 
            value="{{ $pendingTasks }}" 
            icon="fas fa-clock" 
            color="yellow"
            change="-5%" 
            changeType="negative" 
        />
        
        <x-stat-card 
            label="Completed Tasks" 
            value="{{ $completedTasks }}" 
            icon="fas fa-check-circle" 
            color="green"
            change="+18%" 
            changeType="positive" 
        />
    </div>

    <!-- Content Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Recent Tasks -->
        <div class="lg:col-span-2">
            <x-card title="Recent Tasks" icon="fas fa-tasks">
                <x-slot name="actions">
                    <x-button type="primary" size="sm" icon="fas fa-plus" href="{{ route('tasks.create') }}">
                        New Task
                    </x-button>
                </x-slot>
                
                @if($recentTasks->count() > 0)
                    <div class="space-y-4">
                        @foreach($recentTasks as $task)
                            <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors duration-200">
                                <div class="flex-1">
                                    <div class="flex items-center space-x-3">
                                        <div class="w-10 h-10 bg-gradient-to-br from-blue-500 to-blue-600 rounded-lg flex items-center justify-center text-white font-medium text-sm">
                                            {{ strtoupper(substr($task->title, 0, 2)) }}
                                        </div>
                                        <div>
                                            <h4 class="font-medium text-gray-900">{{ $task->title }}</h4>
                                            <p class="text-sm text-gray-500">{{ Str::limit($task->description, 50) }}</p>
                                            <div class="flex items-center space-x-4 mt-1">
                                                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium 
                                                    @if($task->status == 'pending') bg-yellow-100 text-yellow-800
                                                    @elseif($task->status == 'in_progress') bg-blue-100 text-blue-800
                                                    @elseif($task->status == 'completed') bg-green-100 text-green-800
                                                    @endif">
                                                    {{ ucfirst(str_replace('_', ' ', $task->status)) }}
                                                </span>
                                                
                                                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium 
                                                    @if($task->priority == 'low') bg-gray-100 text-gray-800
                                                    @elseif($task->priority == 'medium') bg-yellow-100 text-yellow-800
                                                    @elseif($task->priority == 'high') bg-red-100 text-red-800
                                                    @endif">
                                                    <i class="fas fa-flag mr-1"></i>
                                                    {{ ucfirst($task->priority) }}
                                                </span>
                                                
                                                @if($task->due_date)
                                                    <span class="text-xs text-gray-500">
                                                        <i class="fas fa-calendar mr-1"></i>
                                                        {{ \Carbon\Carbon::parse($task->due_date)->format('M d, Y') }}
                                                    </span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="flex items-center space-x-2">
                                    <x-button type="secondary" size="sm" variant="ghost" href="{{ route('tasks.show', $task) }}">
                                        <i class="fas fa-eye"></i>
                                    </x-button>
                                    <x-button type="primary" size="sm" variant="ghost" href="{{ route('tasks.edit', $task) }}">
                                        <i class="fas fa-edit"></i>
                                    </x-button>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    
                    <div class="mt-6 text-center">
                        <x-button type="secondary" variant="outline" href="{{ route('tasks.index') }}">
                            View All Tasks
                        </x-button>
                    </div>
                @else
                    <div class="text-center py-12">
                        <div class="w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                            <i class="fas fa-tasks text-gray-400 text-2xl"></i>
                        </div>
                        <h3 class="text-lg font-medium text-gray-900 mb-2">No tasks yet</h3>
                        <p class="text-gray-500 mb-6">Get started by creating your first task.</p>
                        <x-button type="primary" icon="fas fa-plus" href="{{ route('tasks.create') }}">
                            Create Task
                        </x-button>
                    </div>
                @endif
            </x-card>
        </div>

        <!-- Quick Actions & Stats -->
        <div class="space-y-6">
            <!-- Quick Actions -->
            <x-card title="Quick Actions" icon="fas fa-rocket">
                <div class="space-y-3">
                    <x-button type="primary" class="w-full justify-start" icon="fas fa-plus" href="{{ route('tasks.create') }}">
                        Create New Task
                    </x-button>
                    <x-button type="secondary" class="w-full justify-start" icon="fas fa-list" href="{{ route('tasks.index') }}">
                        View All Tasks
                    </x-button>
                    <x-button type="info" class="w-full justify-start" icon="fas fa-user-cog" href="{{ route('profile.edit') }}">
                        Edit Profile
                    </x-button>
                </div>
            </x-card>

            <!-- Task Status Chart -->
            <x-card title="Task Overview" icon="fas fa-chart-pie">
                <div class="space-y-4">
                    <!-- Pending -->
                    <div class="flex items-center justify-between">
                        <span class="text-sm font-medium text-gray-600">Pending</span>
                        <span class="text-sm font-bold text-gray-900">{{ $pendingTasks }}</span>
                    </div>
                    <div class="w-full bg-gray-200 rounded-full h-2">
                        <div class="bg-yellow-500 h-2 rounded-full" style="width: {{ $myTasks > 0 ? ($pendingTasks / $myTasks) * 100 : 0 }}%"></div>
                    </div>

                    <!-- Completed -->
                    <div class="flex items-center justify-between">
                        <span class="text-sm font-medium text-gray-600">Completed</span>
                        <span class="text-sm font-bold text-gray-900">{{ $completedTasks }}</span>
                    </div>
                    <div class="w-full bg-gray-200 rounded-full h-2">
                        <div class="bg-green-500 h-2 rounded-full" style="width: {{ $myTasks > 0 ? ($completedTasks / $myTasks) * 100 : 0 }}%"></div>
                    </div>
                </div>
            </x-card>
        </div>
    </div>
</x-app-layout>