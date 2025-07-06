<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div class="flex items-center space-x-3">
                <div class="w-8 h-8 bg-gradient-to-br from-orange-500 to-orange-600 rounded-lg flex items-center justify-center">
                    <i class="fas fa-chart-bar text-white text-sm"></i>
                </div>
                <div>
                    <h2 class="text-2xl font-bold text-gray-900">Reports & Analytics</h2>
                    <p class="text-sm text-gray-500">System performance and insights</p>
                </div>
            </div>
            <x-button type="secondary" variant="outline" href="{{ route('dashboard') }}">
                <i class="fas fa-arrow-left mr-2"></i>Back to Dashboard
            </x-button>
        </div>
    </x-slot>

    <!-- Summary Stats -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-6 mb-8">
        <x-stat-card 
            label="Total Tasks" 
            value="{{ $totalTasks }}" 
            icon="fas fa-tasks" 
            color="blue"
        />
        
        <x-stat-card 
            label="Total Users" 
            value="{{ $totalUsers }}" 
            icon="fas fa-users" 
            color="green"
        />
        
        <x-stat-card 
            label="Pending" 
            value="{{ $pendingTasks }}" 
            icon="fas fa-clock" 
            color="yellow"
        />
        
        <x-stat-card 
            label="In Progress" 
            value="{{ $inProgressTasks }}" 
            icon="fas fa-spinner" 
            color="blue"
        />
        
        <x-stat-card 
            label="Completed" 
            value="{{ $completedTasks }}" 
            icon="fas fa-check-circle" 
            color="green"
        />
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Task Priority Distribution -->
        <x-card title="Task Priority Distribution" icon="fas fa-flag">
            <div class="space-y-4">
                @foreach($tasksByPriority as $priority => $count)
                    <div class="flex items-center justify-between">
                        <div class="flex items-center space-x-3">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-sm font-medium 
                                @if($priority == 'low') bg-gray-100 text-gray-800
                                @elseif($priority == 'medium') bg-yellow-100 text-yellow-800
                                @elseif($priority == 'high') bg-red-100 text-red-800
                                @endif">
                                <i class="fas fa-flag mr-1"></i>
                                {{ ucfirst($priority) }} Priority
                            </span>
                        </div>
                        <div class="flex items-center space-x-2">
                            <span class="text-sm font-medium">{{ $count }}</span>
                            <div class="w-24 bg-gray-200 rounded-full h-2">
                                <div class="
                                    @if($priority == 'low') bg-gray-500
                                    @elseif($priority == 'medium') bg-yellow-500
                                    @elseif($priority == 'high') bg-red-500
                                    @endif
                                    h-2 rounded-full" style="width: {{ $totalTasks > 0 ? ($count / $totalTasks) * 100 : 0 }}%"></div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </x-card>

        <!-- Top Users by Task Count -->
        <x-card title="Top Users by Task Count" icon="fas fa-user-chart">
            @if($tasksByUser->count() > 0)
                <div class="space-y-3">
                    @foreach($tasksByUser as $user)
                        <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                            <div class="flex items-center space-x-3">
                                <div class="w-10 h-10 bg-gradient-to-br from-blue-500 to-blue-600 rounded-full flex items-center justify-center text-white font-medium text-sm">
                                    {{ strtoupper(substr($user->name, 0, 2)) }}
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-gray-900">{{ $user->name }}</p>
                                    <p class="text-xs text-gray-500">{{ $user->email }}</p>
                                </div>
                            </div>
                            <div class="text-right">
                                <p class="text-lg font-bold text-gray-900">{{ $user->tasks_count }}</p>
                                <p class="text-xs text-gray-500">tasks</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-6">
                    <i class="fas fa-users text-gray-400 text-2xl mb-2"></i>
                    <p class="text-sm text-gray-500">No user data available</p>
                </div>
            @endif
        </x-card>
    </div>

    <!-- Task Status Overview -->
    <div class="mt-6">
        <x-card title="Task Status Overview" icon="fas fa-chart-pie">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Pending Tasks -->
                <div class="text-center">
                    <div class="w-20 h-20 bg-yellow-100 rounded-full flex items-center justify-center mx-auto mb-3">
                        <i class="fas fa-clock text-yellow-600 text-2xl"></i>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900">{{ $pendingTasks }}</h3>
                    <p class="text-sm text-gray-500">Pending Tasks</p>
                    <p class="text-xs text-yellow-600 mt-1">
                        {{ $totalTasks > 0 ? round(($pendingTasks / $totalTasks) * 100, 1) : 0 }}% of total
                    </p>
                </div>

                <!-- In Progress Tasks -->
                <div class="text-center">
                    <div class="w-20 h-20 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-3">
                        <i class="fas fa-spinner text-blue-600 text-2xl"></i>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900">{{ $inProgressTasks }}</h3>
                    <p class="text-sm text-gray-500">In Progress</p>
                    <p class="text-xs text-blue-600 mt-1">
                        {{ $totalTasks > 0 ? round(($inProgressTasks / $totalTasks) * 100, 1) : 0 }}% of total
                    </p>
                </div>

                <!-- Completed Tasks -->
                <div class="text-center">
                    <div class="w-20 h-20 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-3">
                        <i class="fas fa-check-circle text-green-600 text-2xl"></i>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900">{{ $completedTasks }}</h3>
                    <p class="text-sm text-gray-500">Completed Tasks</p>
                    <p class="text-xs text-green-600 mt-1">
                        {{ $totalTasks > 0 ? round(($completedTasks / $totalTasks) * 100, 1) : 0 }}% of total
                    </p>
                </div>
            </div>

            <div class="mt-8 text-center">
                <h4 class="text-lg font-medium text-gray-900 mb-2">Overall Completion Rate</h4>
                <div class="w-full bg-gray-200 rounded-full h-4 mb-2">
                    <div class="bg-green-500 h-4 rounded-full" style="width: {{ $totalTasks > 0 ? ($completedTasks / $totalTasks) * 100 : 0 }}%"></div>
                </div>
                <p class="text-2xl font-bold text-green-600">
                    {{ $totalTasks > 0 ? round(($completedTasks / $totalTasks) * 100, 1) : 0 }}%
                </p>
            </div>
        </x-card>
    </div>
</x-app-layout>
