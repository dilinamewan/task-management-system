<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div class="flex items-center space-x-3">
                <div class="w-8 h-8 bg-gradient-to-br from-blue-500 to-blue-600 rounded-lg flex items-center justify-center">
                    <i class="fas fa-tasks text-white text-sm"></i>
                </div>
                <div>
                    <h2 class="text-2xl font-bold text-gray-900">Tasks</h2>
                    <p class="text-sm text-gray-500">Manage and track your tasks</p>
                </div>
            </div>
            <x-button type="primary" icon="fas fa-plus" href="{{ route('tasks.create') }}">
                New Task
            </x-button>
        </div>
    </x-slot>

    <!-- Search and Filter Section -->
    <div class="mb-8">
        <x-card>
            <form method="GET" action="{{ route('tasks.index') }}">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                    <div class="md:col-span-2">
                        <x-form-input 
                            name="search" 
                            placeholder="Search tasks..." 
                            value="{{ request('search') }}"
                            icon="fas fa-search"
                        />
                    </div>
                    <div>
                        <x-form-input type="select" name="status" label="">
                            <option value="">All Status</option>
                            <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="in_progress" {{ request('status') == 'in_progress' ? 'selected' : '' }}>In Progress</option>
                            <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Completed</option>
                        </x-form-input>
                    </div>
                    <div class="flex items-end space-x-3">
                        <x-button type="primary" buttonType="submit" class="flex-1">
                            <i class="fas fa-search mr-2"></i>Search
                        </x-button>
                        <x-button type="secondary" variant="outline" href="{{ route('tasks.index') }}" title="Clear filters">
                            <i class="fas fa-times"></i>
                        </x-button>
                    </div>
                </div>
            </form>
        </x-card>
    </div>

    <!-- Tasks Table -->
    <x-card title="All Tasks" icon="fas fa-list">
        <x-slot name="actions">
            <div class="flex items-center space-x-3">
                <form method="GET" action="{{ route('tasks.export') }}" class="inline">
                    <!-- Pass current filters to export -->
                    <input type="hidden" name="search" value="{{ request('search') }}">
                    <input type="hidden" name="status" value="{{ request('status') }}">
                    <x-button type="secondary" variant="outline" size="sm" buttonType="submit">
                        <i class="fas fa-download mr-1"></i>Export
                    </x-button>
                </form>
                <x-button type="primary" size="sm" href="{{ route('tasks.create') }}">
                    <i class="fas fa-plus mr-1"></i>Add Task
                </x-button>
            </div>
        </x-slot>

        @if($tasks->count() > 0)
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Task</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Assigned To</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Priority</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Due Date</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($tasks as $task)
                            <tr class="hover:bg-gray-50 transition-colors duration-200">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="w-10 h-10 bg-gradient-to-br from-blue-500 to-blue-600 rounded-lg flex items-center justify-center text-white font-medium text-sm mr-3">
                                            {{ strtoupper(substr($task->title, 0, 2)) }}
                                        </div>
                                        <div>
                                            <div class="text-sm font-medium text-gray-900">{{ $task->title }}</div>
                                            <div class="text-sm text-gray-500">{{ Str::limit($task->description, 40) }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="w-8 h-8 bg-gradient-to-br from-green-500 to-green-600 rounded-full flex items-center justify-center text-white text-xs font-medium mr-2">
                                            {{ strtoupper(substr($task->user->name, 0, 2)) }}
                                        </div>
                                        <div>
                                            <div class="text-sm font-medium text-gray-900">{{ $task->user->name }}</div>
                                            <div class="text-xs text-gray-500">{{ $task->user->email }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
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
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                        @if($task->priority == 'low') bg-gray-100 text-gray-800
                                        @elseif($task->priority == 'medium') bg-yellow-100 text-yellow-800
                                        @elseif($task->priority == 'high') bg-red-100 text-red-800
                                        @endif">
                                        <i class="fas fa-flag mr-1"></i>
                                        {{ ucfirst($task->priority) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    @if($task->due_date)
                                        <div class="flex items-center">
                                            <i class="fas fa-calendar text-gray-400 mr-1"></i>
                                            {{ \Carbon\Carbon::parse($task->due_date)->format('M d, Y') }}
                                        </div>
                                        @if(\Carbon\Carbon::parse($task->due_date)->isPast() && $task->status != 'completed')
                                            <span class="text-xs text-red-600 font-medium">Overdue</span>
                                        @endif
                                    @else
                                        <span class="text-gray-400">No due date</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <div class="flex items-center space-x-2">
                                        <x-button type="secondary" size="sm" variant="ghost" href="{{ route('tasks.show', $task) }}" title="View">
                                            <i class="fas fa-eye"></i>
                                        </x-button>
                                        @can('view', $task)
                                            <form method="POST" action="{{ route('tasks.duplicate', $task) }}" class="inline">
                                                @csrf
                                                <x-button type="success" size="sm" variant="ghost" buttonType="submit" title="Duplicate">
                                                    <i class="fas fa-copy"></i>
                                                </x-button>
                                            </form>
                                        @endcan
                                        @can('update', $task)
                                            <x-button type="primary" size="sm" variant="ghost" href="{{ route('tasks.edit', $task) }}" title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </x-button>
                                        @endcan
                                        @can('delete', $task)
                                            <form method="POST" action="{{ route('tasks.destroy', $task) }}" class="inline" 
                                                  onsubmit="return confirm('Are you sure you want to delete this task?')">
                                                @csrf
                                                @method('DELETE')
                                                <x-button type="danger" size="sm" variant="ghost" buttonType="submit" title="Delete">
                                                    <i class="fas fa-trash"></i>
                                                </x-button>
                                            </form>
                                        @endcan
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            @if($tasks->hasPages())
                <div class="mt-6 flex items-center justify-between border-t border-gray-200 pt-6">
                    <div class="flex items-center text-sm text-gray-500">
                        Showing {{ $tasks->firstItem() }} to {{ $tasks->lastItem() }} of {{ $tasks->total() }} results
                    </div>
                    <div>
                        {{ $tasks->appends(request()->query())->links() }}
                    </div>
                </div>
            @endif
        @else
            <div class="text-center py-12">
                <div class="w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-tasks text-gray-400 text-2xl"></i>
                </div>
                <h3 class="text-lg font-medium text-gray-900 mb-2">No tasks found</h3>
                <p class="text-gray-500 mb-6">
                    @if(request()->filled('search') || request()->filled('status'))
                        Try adjusting your search criteria or 
                        <a href="{{ route('tasks.index') }}" class="text-blue-600 hover:text-blue-500">clear filters</a>.
                    @else
                        Get started by creating your first task.
                    @endif
                </p>
                <x-button type="primary" icon="fas fa-plus" href="{{ route('tasks.create') }}">
                    Create Task
                </x-button>
            </div>
        @endif
    </x-card>
</x-app-layout>