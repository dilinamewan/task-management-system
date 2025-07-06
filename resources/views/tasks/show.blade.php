<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div class="flex items-center space-x-3">
                <div class="w-8 h-8 bg-gradient-to-br from-blue-500 to-blue-600 rounded-lg flex items-center justify-center">
                    <i class="fas fa-tasks text-white text-sm"></i>
                </div>
                <div>
                    <h2 class="text-2xl font-bold text-gray-900">{{ $task->title }}</h2>
                    <p class="text-sm text-gray-500">Task Details & Information</p>
                </div>
            </div>
            <div class="flex items-center space-x-3">
                <x-button type="secondary" variant="outline" href="{{ route('tasks.index') }}" size="md">
                    <i class="fas fa-arrow-left mr-2"></i>Back to Tasks
                </x-button>
                @can('update', $task)
                    <x-button type="primary" href="{{ route('tasks.edit', $task) }}" size="md">
                        <i class="fas fa-edit mr-2"></i>Edit Task
                    </x-button>
                @endcan
            </div>
        </div>
    </x-slot>

    <div class="max-w-6xl mx-auto">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Main Task Details -->
            <div class="lg:col-span-2">
                <x-card title="Task Information" icon="fas fa-info-circle">
                    <div class="space-y-6">
                        <!-- Task Title and Description -->
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900 mb-2">{{ $task->title }}</h3>
                            <div class="prose prose-sm text-gray-600">
                                {{ $task->description }}
                            </div>
                        </div>

                        <!-- Task Properties -->
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 border-t border-gray-200 pt-6">
                            <div>
                                <label class="text-sm font-medium text-gray-500">Status</label>
                                <div class="mt-1">
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium 
                                        @if($task->status == 'pending') bg-yellow-100 text-yellow-800
                                        @elseif($task->status == 'in_progress') bg-blue-100 text-blue-800
                                        @elseif($task->status == 'completed') bg-green-100 text-green-800
                                        @endif">
                                        @if($task->status == 'pending')
                                            <i class="fas fa-clock mr-1"></i>
                                        @elseif($task->status == 'in_progress')
                                            <i class="fas fa-spinner mr-1"></i>
                                        @elseif($task->status == 'completed')
                                            <i class="fas fa-check mr-1"></i>
                                        @endif
                                        {{ ucfirst(str_replace('_', ' ', $task->status)) }}
                                    </span>
                                </div>
                            </div>

                            <div>
                                <label class="text-sm font-medium text-gray-500">Priority</label>
                                <div class="mt-1">
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium 
                                        @if($task->priority == 'low') bg-gray-100 text-gray-800
                                        @elseif($task->priority == 'medium') bg-yellow-100 text-yellow-800
                                        @elseif($task->priority == 'high') bg-red-100 text-red-800
                                        @endif">
                                        <i class="fas fa-flag mr-1"></i>
                                        {{ ucfirst($task->priority) }}
                                    </span>
                                </div>
                            </div>

                            <div>
                                <label class="text-sm font-medium text-gray-500">Due Date</label>
                                <div class="mt-1">
                                    @if($task->due_date)
                                        <div class="flex items-center text-sm text-gray-900">
                                            <i class="fas fa-calendar text-gray-400 mr-1"></i>
                                            {{ $task->due_date->format('M d, Y') }}
                                        </div>
                                        @if($task->due_date->isPast() && $task->status != 'completed')
                                            <span class="text-xs text-red-600 font-medium">Overdue</span>
                                        @endif
                                    @else
                                        <span class="text-sm text-gray-400">No due date set</span>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <!-- Timestamps -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 border-t border-gray-200 pt-6">
                            <div>
                                <label class="text-sm font-medium text-gray-500">Created</label>
                                <p class="mt-1 text-sm text-gray-900">
                                    {{ $task->created_at->format('M d, Y \a\t g:i A') }}
                                </p>
                                <p class="text-xs text-gray-500">
                                    {{ $task->created_at->diffForHumans() }}
                                </p>
                            </div>

                            <div>
                                <label class="text-sm font-medium text-gray-500">Last Updated</label>
                                <p class="mt-1 text-sm text-gray-900">
                                    {{ $task->updated_at->format('M d, Y \a\t g:i A') }}
                                </p>
                                <p class="text-xs text-gray-500">
                                    {{ $task->updated_at->diffForHumans() }}
                                </p>
                            </div>
                        </div>
                    </div>
                </x-card>
            </div>

            <!-- Sidebar -->
            <div class="space-y-6">
                <!-- Assigned User -->
                <x-card title="Assigned To" icon="fas fa-user">
                    <div class="flex items-center space-x-3">
                        <div class="w-12 h-12 bg-gradient-to-br from-blue-500 to-blue-600 rounded-full flex items-center justify-center text-white font-medium">
                            {{ strtoupper(substr($task->user->name, 0, 2)) }}
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-900">{{ $task->user->name }}</p>
                            <p class="text-sm text-gray-500">{{ $task->user->email }}</p>
                            @if($task->user->isAdmin())
                                <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-purple-100 text-purple-800 mt-1">
                                    <i class="fas fa-crown mr-1"></i>Admin
                                </span>
                            @endif
                        </div>
                    </div>
                </x-card>

                <!-- Actions -->
                <x-card title="Actions" icon="fas fa-cog">
                    <div class="space-y-3">
                        @can('update', $task)
                            <x-button type="primary" variant="solid" class="w-full justify-center" href="{{ route('tasks.edit', $task) }}">
                                <i class="fas fa-edit mr-2"></i>Edit Task
                            </x-button>
                        @endcan
                        
                        @can('view', $task)
                            <form method="POST" action="{{ route('tasks.duplicate', $task) }}" class="w-full">
                                @csrf
                                <x-button type="secondary" variant="outline" class="w-full justify-center" buttonType="submit">
                                    <i class="fas fa-copy mr-2"></i>Duplicate Task
                                </x-button>
                            </form>
                        @endcan

                        @can('delete', $task)
                            <form method="POST" action="{{ route('tasks.destroy', $task) }}" 
                                  onsubmit="return confirm('Are you sure you want to delete this task?')" 
                                  class="w-full">
                                @csrf
                                @method('DELETE')
                                <x-button type="danger" variant="outline" class="w-full justify-center" buttonType="submit">
                                    <i class="fas fa-trash mr-2"></i>Delete Task
                                </x-button>
                            </form>
                        @endcan
                    </div>
                </x-card>

                <!-- Task Progress -->
                @if($task->status == 'completed')
                    <x-card title="Completion" icon="fas fa-check-circle">
                        <div class="text-center">
                            <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-3">
                                <i class="fas fa-check-circle text-green-600 text-2xl"></i>
                            </div>
                            <h3 class="text-lg font-medium text-gray-900 mb-1">Task Completed!</h3>
                            <p class="text-sm text-gray-500">
                                Completed {{ $task->updated_at->diffForHumans() }}
                            </p>
                        </div>
                    </x-card>
                @elseif($task->due_date && $task->due_date->isPast())
                    <div class="bg-red-50 border border-red-200 rounded-lg p-4">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <i class="fas fa-exclamation-triangle text-red-400"></i>
                            </div>
                            <div class="ml-3">
                                <h3 class="text-sm font-medium text-red-800">Task Overdue</h3>
                                <p class="text-sm text-red-700 mt-1">
                                    This task was due {{ $task->due_date->diffForHumans() }}.
                                </p>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>