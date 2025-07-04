<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Task Details') }}
        </h2>
    </x-slot>

    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0">{{ $task->title }}</h5>
                    <div class="btn-group">
                        @can('update', $task)
                            <a href="{{ route('tasks.edit', $task) }}" class="btn btn-warning">
                                <i class="fas fa-edit"></i> Edit
                            </a>
                        @endcan
                        @can('delete', $task)
                            <button type="button" class="btn btn-danger" onclick="deleteTask({{ $task->id }})">
                                <i class="fas fa-trash"></i> Delete
                            </button>
                        @endcan
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-8">
                            <h6 class="text-muted">Description</h6>
                            <p class="mb-3">{{ $task->description }}</p>
                            
                            <h6 class="text-muted">Details</h6>
                            <table class="table table-borderless">
                                <tr>
                                    <td><strong>Status:</strong></td>
                                    <td>
                                        <span class="badge {{ $task->status_badge }}">
                                            {{ ucfirst(str_replace('_', ' ', $task->status)) }}
                                        </span>
                                    </td>
                                </tr>
                                <tr>
                                    <td><strong>Priority:</strong></td>
                                    <td>
                                        <span class="badge {{ $task->priority_badge }}">
                                            {{ ucfirst($task->priority) }}
                                        </span>
                                    </td>
                                </tr>
                                <tr>
                                    <td><strong>Due Date:</strong></td>
                                    <td>
                                        {{ $task->due_date->format('F j, Y') }}
                                        @if($task->due_date->isPast() && $task->status !== 'completed')
                                            <span class="text-danger ms-2">
                                                <i class="fas fa-exclamation-triangle"></i> Overdue
                                            </span>
                                        @endif
                                    </td>
                                </tr>
                                @if(auth()->user()->isAdmin())
                                    <tr>
                                        <td><strong>Assigned To:</strong></td>
                                        <td>{{ $task->user->name }}</td>
                                    </tr>
                                @endif
                                <tr>
                                    <td><strong>Created:</strong></td>
                                    <td>{{ $task->created_at->format('F j, Y g:i A') }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Last Updated:</strong></td>
                                    <td>{{ $task->updated_at->format('F j, Y g:i A') }}</td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-4">
                            <div class="card bg-light">
                                <div class="card-body">
                                    <h6 class="card-title">Task Progress</h6>
                                    @php
                                        $progress = 0;
                                        if ($task->status === 'in_progress') $progress = 50;
                                        elseif ($task->status === 'completed') $progress = 100;
                                    @endphp
                                    <div class="progress mb-2">
                                        <div class="progress-bar" role="progressbar" style="width: {{ $progress }}%"></div>
                                    </div>
                                    <small class="text-muted">{{ $progress }}% Complete</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <a href="{{ route('tasks.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Back to Tasks
                    </a>
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