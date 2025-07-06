<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div class="flex items-center space-x-3">
                <div class="w-8 h-8 bg-gradient-to-br from-purple-500 to-purple-600 rounded-lg flex items-center justify-center">
                    <i class="fas fa-users text-white text-sm"></i>
                </div>
                <div>
                    <h2 class="text-2xl font-bold text-gray-900">User Management</h2>
                    <p class="text-sm text-gray-500">Manage system users and permissions</p>
                </div>
            </div>
            <x-button type="primary" icon="fas fa-user-plus" href="{{ route('users.create') }}">
                New User
            </x-button>
        </div>
    </x-slot>

    <!-- Search and Filter Section -->
    <div class="mb-8">
        <x-card>
            <form method="GET" action="{{ route('users.index') }}">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                    <div class="md:col-span-3">
                        <x-form-input 
                            name="search" 
                            placeholder="Search users by name or email..." 
                            value="{{ request('search') }}"
                            icon="fas fa-search"
                        />
                    </div>
                    <div class="flex items-end space-x-3">
                        <x-button type="primary" buttonType="submit" class="flex-1">
                            <i class="fas fa-search mr-2"></i>Search
                        </x-button>
                        @if(request('search'))
                            <x-button type="secondary" variant="outline" href="{{ route('users.index') }}" title="Clear search">
                                <i class="fas fa-times"></i>
                            </x-button>
                        @endif
                    </div>
                </div>
            </form>
        </x-card>
    </div>

    <!-- Users Table -->
    <x-card title="All Users" icon="fas fa-users">
        <x-slot name="actions">
            <div class="flex items-center space-x-3">
                <span class="text-sm text-gray-500">{{ $users->total() }} users total</span>
                <form method="GET" action="{{ route('users.export') }}" class="inline">
                    <!-- Pass current search filter to export -->
                    <input type="hidden" name="search" value="{{ request('search') }}">
                    <x-button type="secondary" variant="outline" size="sm" buttonType="submit">
                        <i class="fas fa-download mr-1"></i>Export
                    </x-button>
                </form>
                <x-button type="primary" size="sm" href="{{ route('users.create') }}">
                    <i class="fas fa-user-plus mr-1"></i>Add User
                </x-button>
            </div>
        </x-slot>

        @if($users->count() > 0)
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">User</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Role</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tasks</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Joined</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($users as $user)
                            <tr class="hover:bg-gray-50 transition-colors duration-200">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="w-12 h-12 bg-gradient-to-br from-blue-500 to-blue-600 rounded-full flex items-center justify-center text-white font-medium mr-4">
                                            {{ strtoupper(substr($user->name, 0, 2)) }}
                                        </div>
                                        <div>
                                            <div class="text-sm font-medium text-gray-900">{{ $user->name }}</div>
                                            <div class="text-sm text-gray-500">{{ $user->email }}</div>
                                            @if($user->email_verified_at)
                                                <div class="flex items-center mt-1">
                                                    <i class="fas fa-check-circle text-green-500 text-xs mr-1"></i>
                                                    <span class="text-xs text-green-600">Verified</span>
                                                </div>
                                            @else
                                                <div class="flex items-center mt-1">
                                                    <i class="fas fa-exclamation-circle text-yellow-500 text-xs mr-1"></i>
                                                    <span class="text-xs text-yellow-600">Unverified</span>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if($user->isAdmin())
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-purple-100 text-purple-800">
                                            <i class="fas fa-crown mr-1"></i>
                                            Admin
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                            <i class="fas fa-user mr-1"></i>
                                            User
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    <div class="flex items-center space-x-2">
                                        <span class="font-medium">{{ $user->tasks_count ?? 0 }}</span>
                                        <span class="text-gray-400">tasks</span>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if($user->email_verified_at)
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                            <i class="fas fa-check mr-1"></i>
                                            Active
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                            <i class="fas fa-clock mr-1"></i>
                                            Pending
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    <div class="flex items-center">
                                        <i class="fas fa-calendar text-gray-400 mr-1"></i>
                                        {{ $user->created_at->format('M d, Y') }}
                                    </div>
                                    <div class="text-xs text-gray-400">
                                        {{ $user->created_at->diffForHumans() }}
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <div class="flex items-center space-x-2">
                                        <x-button type="secondary" size="sm" variant="ghost" href="{{ route('users.show', $user) }}" title="View Details">
                                            <i class="fas fa-eye"></i>
                                        </x-button>
                                        <x-button type="primary" size="sm" variant="ghost" href="{{ route('users.edit', $user) }}" title="Edit User">
                                            <i class="fas fa-edit"></i>
                                        </x-button>
                                        @if($user->id !== auth()->id())
                                            <form method="POST" action="{{ route('users.destroy', $user) }}" class="inline" 
                                                  onsubmit="return confirm('Are you sure you want to delete this user? This will also delete all their tasks.')">
                                                @csrf
                                                @method('DELETE')
                                                <x-button type="danger" size="sm" variant="ghost" buttonType="submit" title="Delete User">
                                                    <i class="fas fa-trash"></i>
                                                </x-button>
                                            </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            @if($users->hasPages())
                <div class="mt-6 flex items-center justify-between border-t border-gray-200 pt-6">
                    <div class="flex items-center text-sm text-gray-500">
                        Showing {{ $users->firstItem() }} to {{ $users->lastItem() }} of {{ $users->total() }} results
                    </div>
                    <div>
                        {{ $users->appends(request()->query())->links() }}
                    </div>
                </div>
            @endif
        @else
            <div class="text-center py-12">
                <div class="w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-users text-gray-400 text-2xl"></i>
                </div>
                <h3 class="text-lg font-medium text-gray-900 mb-2">No users found</h3>
                <p class="text-gray-500 mb-6">
                    @if(request()->filled('search'))
                        No users match your search criteria. 
                        <a href="{{ route('users.index') }}" class="text-blue-600 hover:text-blue-500">Clear search</a> to see all users.
                    @else
                        Get started by creating the first user account.
                    @endif
                </p>
                <x-button type="primary" icon="fas fa-user-plus" href="{{ route('users.create') }}">
                    Create User
                </x-button>
            </div>
        @endif
    </x-card>
</x-app-layout>