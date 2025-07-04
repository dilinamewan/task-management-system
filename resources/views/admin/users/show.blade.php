<x-app-layout>
    <x-slot name="header">
        <div class="d-flex justify-content-between align-items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('User Details') }} - {{ $user->name }}
            </h2>
            <a href="{{ route('users.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Back to Users
            </a>
        </div>
    </x-slot>

    <div class="row">
        <!-- User Information Card -->
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-user"></i> User Information
                    </h5>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label class="form-label fw-bold">Name:</label>
                        <p class="mb-2">{{ $user->name }}</p>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Email:</label>
                        <p class="mb-2">{{ $user->email }}</p>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Role:</label>
                        <p class="mb-2">
                            <span class="badge bg-{{ $user->role === 'admin' ? 'danger' : 'primary' }}">
                                {{ ucfirst($user->role) }}
                            </span>
                        </p>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Email Verified:</label>
                        <p class="mb-2">
                            @if($user->email_verified_at)
                                <span class="badge bg-success">
                                    <i class="fas fa-check"></i> Verified
                                </span>
                                <br>
                                <small class="text-muted">{{ $user->email_verified_at->format('M d, Y H:i') }}</small>
                            @else
                                <span class="badge bg-warning">
                                    <i class="fas fa-exclamation-triangle"></i> Not Verified
                                </span>
                            @endif
                        </p>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Joined:</label>
                        <p class="mb-2">{{ $user->created_at->format('M d, Y H:i') }}</p>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Last Updated:</label>
                        <p class="mb-2">{{ $user->updated_at->format('M d, Y H:i') }}</p>
                    </div>
                    
                    <!-- Action Buttons -->
                    <div class="mt-4">
                        <a href="{{ route('users.edit', $user) }}" class="btn btn-warning btn-sm me-2">
                            <i class="fas fa-edit"></i> Edit User
                        </a>
                        <button type="button" class="btn btn-danger btn-sm" onclick="deleteUser({{ $user->id }})">
                            <i class="fas fa-trash"></i> Delete User
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- User Tasks Card -->
        <div class="col-md-8">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-tasks"></i> User Tasks ({{ $tasks->total() }})
                    </h5>
                    <div>
                        <span class="badge bg-info">Total: {{ $tasks->total() }}</span>
                    </div>
                </div>
                <div class="card-body">
                    @if($tasks->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Title</th>
                                        <th>Priority</th>
                                        <th>Status</th>
                                        <th>Due Date</th>
                                        <th>Created</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($tasks as $task)
                                        <tr>
                                            <td>
                                                <strong>{{ $task->title }}</strong>
                                                @if($task->description)
                                                    <br>
                                                    <small class="text-muted">{{ Str::limit($task->description, 50) }}</small>
                                                @endif
                                            </td>
                                            <td>
                                                <span class="badge bg-{{ $task->priority === 'high' ? 'danger' : ($task->priority === 'medium' ? 'warning' : 'secondary') }}">
                                                    {{ ucfirst($task->priority) }}
                                                </span>
                                            </td>
                                            <td>
                                                <span class="badge bg-{{ $task->status === 'completed' ? 'success' : ($task->status === 'in_progress' ? 'info' : 'secondary') }}">
                                                    {{ ucfirst(str_replace('_', ' ', $task->status)) }}
                                                </span>
                                            </td>
                                            <td>
                                                @if($task->due_date)
                                                    {{ \Carbon\Carbon::parse($task->due_date)->format('M d, Y') }}
                                                    @if(\Carbon\Carbon::parse($task->due_date)->isPast() && $task->status !== 'completed')
                                                        <br><small class="text-danger">Overdue</small>
                                                    @endif
                                                @else
                                                    <small class="text-muted">No due date</small>
                                                @endif
                                            </td>
                                            <td>{{ $task->created_at->format('M d, Y') }}</td>
                                            <td>
                                                <div class="btn-group btn-group-sm">
                                                    <a href="{{ route('tasks.show', $task) }}" class="btn btn-info btn-sm">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                    <a href="{{ route('tasks.edit', $task) }}" class="btn btn-warning btn-sm">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        
                        <!-- Pagination -->
                        @if($tasks->hasPages())
                            <div class="d-flex justify-content-center mt-4">
                                {{ $tasks->links() }}
                            </div>
                        @endif
                    @else
                        <div class="text-center py-5">
                            <i class="fas fa-tasks fa-3x text-muted mb-3"></i>
                            <h5 class="text-muted">No tasks found</h5>
                            <p class="text-muted">This user hasn't created any tasks yet.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Delete User Modal Script -->
    <script>
        function deleteUser(userId) {
            if (confirm('Are you sure you want to delete this user? This action cannot be undone.')) {
                // Create a form to submit the delete request
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = `/users/${userId}`;
                
                // Add CSRF token
                const csrfToken = document.createElement('input');
                csrfToken.type = 'hidden';
                csrfToken.name = '_token';
                csrfToken.value = '{{ csrf_token() }}';
                form.appendChild(csrfToken);
                
                // Add method spoofing for DELETE
                const methodInput = document.createElement('input');
                methodInput.type = 'hidden';
                methodInput.name = '_method';
                methodInput.value = 'DELETE';
                form.appendChild(methodInput);
                
                // Submit the form
                document.body.appendChild(form);
                form.submit();
            }
        }
    </script>
</x-app-layout>
