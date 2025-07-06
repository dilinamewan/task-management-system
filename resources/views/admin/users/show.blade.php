<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div class="flex items-center space-x-3">
                <div class="w-12 h-12 bg-gradient-to-br from-blue-500 to-blue-600 rounded-full flex items-center justify-center text-white font-medium">
                    {{ strtoupper(substr($user->name, 0, 2)) }}
                </div>
                <div>
                    <h2 class="text-2xl font-bold text-gray-900">{{ $user->name }}</h2>
                    <p class="text-sm text-gray-500">User Profile & Activity</p>
                </div>
            </div>
            <x-button type="secondary" variant="outline" href="{{ route('users.index') }}">
                <i class="fas fa-arrow-left mr-2"></i>Back to Users
            </x-button>
        </div>
    </x-slot>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- User Information -->
        <div class="lg:col-span-1">
            <x-card title="User Information" icon="fas fa-user">
                <x-slot name="actions">
                    <x-button type="primary" size="sm" href="{{ route('users.edit', $user) }}">
                        <i class="fas fa-edit"></i>
                    </x-button>
                </x-slot>

                <div class="space-y-6">
                    <!-- Profile Picture -->
                    <div class="text-center">
                        <div class="w-24 h-24 bg-gradient-to-br from-blue-500 to-blue-600 rounded-full flex items-center justify-center text-white font-bold text-2xl mx-auto mb-4">
                            {{ strtoupper(substr($user->name, 0, 2)) }}
                        </div>
                        <h3 class="text-lg font-semibold text-gray-900">{{ $user->name }}</h3>
                        <p class="text-sm text-gray-500">{{ $user->email }}</p>
                    </div>

                    <!-- User Details -->
                    <div class="space-y-4 border-t border-gray-200 pt-6">
                        <div>
                            <label class="text-sm font-medium text-gray-500">Role</label>
                            <div class="mt-1">
                                @if($user->isAdmin())
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-purple-100 text-purple-800">
                                        <i class="fas fa-crown mr-1"></i>
                                        Administrator
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-100 text-blue-800">
                                        <i class="fas fa-user mr-1"></i>
                                        User
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div>
                            <label class="text-sm font-medium text-gray-500">Email Status</label>
                            <div class="mt-1">
                                @if($user->email_verified_at)
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800">
                                        <i class="fas fa-check-circle mr-1"></i>
                                        Verified
                                    </span>
                                    <p class="text-xs text-gray-500 mt-1">
                                        {{ $user->email_verified_at->format('M d, Y \a\t g:i A') }}
                                    </p>
                                @else
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-yellow-100 text-yellow-800">
                                        <i class="fas fa-clock mr-1"></i>
                                        Unverified
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div>
                            <label class="text-sm font-medium text-gray-500">Member Since</label>
                            <p class="mt-1 text-sm text-gray-900">
                                {{ $user->created_at->format('M d, Y') }}
                            </p>
                            <p class="text-xs text-gray-500">
                                {{ $user->created_at->diffForHumans() }}
                            </p>
                        </div>

                        <div>
                            <label class="text-sm font-medium text-gray-500">Last Updated</label>
                            <p class="mt-1 text-sm text-gray-900">
                                {{ $user->updated_at->format('M d, Y \a\t g:i A') }}
                            </p>
                        </div>
                    </div>

                    <!-- Actions -->
                    <div class="space-y-3 border-t border-gray-200 pt-6">
                        <x-button type="primary" class="w-full" href="{{ route('users.edit', $user) }}">
                            <i class="fas fa-edit mr-2"></i>Edit User
                        </x-button>
                        @if($user->id !== auth()->id())
                            <form method="POST" action="{{ route('users.destroy', $user) }}" 
                                  onsubmit="return confirm('Are you sure you want to delete this user? This will also delete all their tasks.')">
                                @csrf
                                @method('DELETE')
                                <x-button type="danger" variant="outline" class="w-full">
                                    <i class="fas fa-trash mr-2"></i>Delete User
                                </x-button>
                            </form>
                        @endif
                    </div>
                </div>
            </x-card>
        </div>

        <!-- User Tasks and Activity -->
        <div class="lg:col-span-2 space-y-8">
            <!-- Task Statistics -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <x-stat-card 
                    label="Total Tasks" 
                    value="{{ $user->tasks->count() }}" 
                    icon="fas fa-tasks" 
                    color="blue"
                />
                
                <x-stat-card 
                    label="Completed" 
                    value="{{ $user->tasks->where('status', 'completed')->count() }}" 
                    icon="fas fa-check-circle" 
                    color="green"
                />
                
                <x-stat-card 
                    label="Pending" 
                    value="{{ $user->tasks->where('status', 'pending')->count() }}" 
                    icon="fas fa-clock" 
                    color="yellow"
                />
            </div>

            <!-- User Tasks -->
            <x-card title="User Tasks" icon="fas fa-list-check">
                <x-slot name="actions">
                    <span class="text-sm text-gray-500">{{ $user->tasks->count() }} total tasks</span>
                </x-slot>

                @if($user->tasks->count() > 0)
                    <div class="space-y-4">
                        @foreach($user->tasks as $task)
                            <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors duration-200">
                                <div class="flex-1">
                                    <div class="flex items-center space-x-3">
                                        <div class="w-10 h-10 bg-gradient-to-br from-blue-500 to-blue-600 rounded-lg flex items-center justify-center text-white font-medium text-sm">
                                            {{ strtoupper(substr($task->title, 0, 2)) }}
                                        </div>
                                        <div>
                                            <h4 class="font-medium text-gray-900">{{ $task->title }}</h4>
                                            <p class="text-sm text-gray-500">{{ Str::limit($task->description, 80) }}</p>
                                            <div class="flex items-center space-x-4 mt-2">
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
                @else
                    <div class="text-center py-12">
                        <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                            <i class="fas fa-tasks text-gray-400 text-xl"></i>
                        </div>
                        <h3 class="text-lg font-medium text-gray-900 mb-2">No tasks assigned</h3>
                        <p class="text-gray-500 mb-4">This user doesn't have any tasks yet.</p>
                        <x-button type="primary" href="{{ route('tasks.create') }}">
                            <i class="fas fa-plus mr-2"></i>Assign First Task
                        </x-button>
                    </div>
                @endif
            </x-card>
        </div>
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
