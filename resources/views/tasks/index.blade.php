<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Tasks') }}
        </h2>
    </x-slot>

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0">All Tasks</h5>
                    <a href="{{ route('tasks.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus"></i> New Task
                    </a>
                </div>
                <div class="card-body">
                    <!-- Search and Filter Form -->
                    <form method="GET" action="{{ route('tasks.index') }}" class="mb-4">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="input-group">
                                    <input type="text" name="search" class="form-control" 
                                           placeholder="Search tasks..." value="{{ request('search') }}">
                                    <button class="btn btn-outline-secondary" type="submit">
                                        <i class="fas fa-search"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <select name="status" class="form-select">
                                    <option value="">All Status</option>
                                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                                    <option value="in_progress" {{ request('status') == 'in_progress' ? 'selected' : '' }}>In Progress</option>
                                    <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Completed</option>
                                </select>
                            </div>
                            <div class="col-md-2">
                                <a href="{{ route('tasks.index') }}" class="btn btn-outline-secondary w-100">
                                    <i class="fas fa-times"></i> Clear
                                </a>
                            </div>
                        </div>
                    </form>

                    @if($tasks->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Title</th>
                                        @if(auth()->user()->isAdmin())
                                            <th>User</th>
                                        @endif
                                        <th>Status</th>
                                        <th>Priority</th>
                                        <th>Due Date</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($tasks as $task)
                                        <tr>
                                            <td>
                                                <strong>{{ $task->title }}</strong>
                                                <br>
                                                <small class="text-muted">
                                                    {{ Str::limit($task->description, 50) }}
                                                </small>
                                            </td>
                                            @if(auth()->user()->isAdmin())
                                                <td>{{ $task->user->name }}</td>
                                            @endif
                                            <td>
                                                <span class="badge {{ $task->status_badge }}">
                                                    {{ ucfirst(str_replace('_', ' ', $task->status)) }}
                                                </span>
                                            </td>
                                            <td>
                                                <span class="badge {{ $task->priority_badge }}">
                                                    {{ ucfirst($task->priority) }}
                                                </span>
                                            </td>
                                            <td>
                                                {{ $task->due_date->format('M d, Y') }}
                                                @if($task->due_date->isPast() && $task->status !== 'completed')
                                                    <br><small class="text-danger">Overdue</small>
                                                @endif
                                            </td>
                                            <td>
                                                <div class="btn-group btn-group-sm">
                                                    <a href="{{ route('tasks.show', $task) }}" class="btn btn-info">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                    @can('view', $task)
                                                        <form method="POST" action="{{ route('tasks.duplicate', $task) }}" class="d-inline">
                                                            @csrf
                                                            <button type="submit" class="btn btn-secondary" title="Duplicate Task">
                                                                <i class="fas fa-copy"></i>
                                                            </button>
                                                        </form>
                                                    @endcan
                                                    @can('update', $task)
                                                        <a href="{{ route('tasks.edit', $task) }}" class="btn btn-warning">
                                                            <i class="fas fa-edit"></i>
                                                        </a>
                                                    @endcan
                                                    @can('delete', $task)
                                                        <button type="button" class="btn btn-danger" 
                                                                onclick="deleteTask({{ $task->id }})">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    @endcan
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        
                        <!-- Pagination -->
                        <div class="d-flex justify-content-center">
                            {{ $tasks->withQueryString()->links() }}
                        </div>
                    @else
                        <div class="text-center py-4">
                            <i class="fas fa-tasks fa-3x text-muted mb-3"></i>
                            <p class="text-muted">No tasks found.</p>
                            <a href="{{ route('tasks.create') }}" class="btn btn-primary">
                                <i class="fas fa-plus"></i> Create New Task
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div class="modal fade" id="deleteModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Confirm Delete</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    Are you sure you want to delete this task?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <form id="deleteForm" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Delete</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        function deleteTask(taskId) {
            const form = document.getElementById('deleteForm');
            form.action = `/tasks/${taskId}`;
            const modal = new bootstrap.Modal(document.getElementById('deleteModal'));
            modal.show();
        }
    </script>
</x-app-layout>