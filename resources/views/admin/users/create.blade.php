<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div class="flex items-center space-x-3">
                <div class="w-8 h-8 bg-gradient-to-br from-green-500 to-green-600 rounded-lg flex items-center justify-center">
                    <i class="fas fa-user-plus text-white text-sm"></i>
                </div>
                <div>
                    <h2 class="text-2xl font-bold text-gray-900">Create New User</h2>
                    <p class="text-sm text-gray-500">Add a new user to the system</p>
                </div>
            </div>
            <x-button type="secondary" variant="outline" href="{{ route('users.index') }}">
                <i class="fas fa-arrow-left mr-2"></i>Back to Users
            </x-button>
        </div>
    </x-slot>

    <div class="max-w-4xl mx-auto">
        <x-card title="User Information" icon="fas fa-user-plus">
            <form method="POST" action="{{ route('users.store') }}" class="space-y-6">
                @csrf
                
                <!-- Personal Information -->
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                    <div>
                        <x-form-input 
                            name="name" 
                            label="Full Name" 
                            placeholder="Enter user's full name..."
                            value="{{ old('name') }}"
                            icon="fas fa-user"
                            required="true"
                            error="{{ $errors->first('name') }}"
                        />
                    </div>
                    
                    <div>
                        <x-form-input 
                            type="email" 
                            name="email" 
                            label="Email Address" 
                            placeholder="Enter email address..."
                            value="{{ old('email') }}"
                            icon="fas fa-envelope"
                            required="true"
                            error="{{ $errors->first('email') }}"
                        />
                    </div>
                </div>

                <!-- Security -->
                <div class="border-t border-gray-200 pt-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4 flex items-center">
                        <i class="fas fa-lock text-gray-400 mr-2"></i>
                        Account Security
                    </h3>
                    
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                        <div>
                            <x-form-input 
                                type="password" 
                                name="password" 
                                label="Password" 
                                placeholder="Enter password (min 8 characters)..."
                                icon="fas fa-key"
                                required="true"
                                error="{{ $errors->first('password') }}"
                                helpText="Password must be at least 8 characters long."
                            />
                        </div>
                        
                        <div>
                            <x-form-input 
                                type="password" 
                                name="password_confirmation" 
                                label="Confirm Password" 
                                placeholder="Confirm password..."
                                icon="fas fa-lock"
                                required="true"
                                helpText="Re-enter the password to confirm."
                            />
                        </div>
                    </div>
                </div>

                <!-- Role Assignment -->
                <div class="border-t border-gray-200 pt-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4 flex items-center">
                        <i class="fas fa-user-tag text-gray-400 mr-2"></i>
                        Role & Permissions
                    </h3>
                    
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                        <div>
                            <x-form-input 
                                type="select" 
                                name="role" 
                                label="User Role" 
                                icon="fas fa-users-cog"
                                required="true"
                                error="{{ $errors->first('role') }}"
                                helpText="Select the role for this user."
                            >
                                <option value="">Select Role</option>
                                <option value="user" {{ old('role', 'user') == 'user' ? 'selected' : '' }}>
                                    👤 Regular User
                                </option>
                                <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>
                                    👑 Administrator
                                </option>
                            </x-form-input>
                        </div>
                    </div>
                </div>

                <!-- Account Information -->
                <div class="border-t border-gray-200 pt-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4 flex items-center">
                        <i class="fas fa-info-circle text-gray-400 mr-2"></i>
                        Account Information
                    </h3>
                    
                    <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <i class="fas fa-envelope text-blue-400"></i>
                            </div>
                            <div class="ml-3">
                                <h4 class="text-sm font-medium text-blue-800">Email verification will be required</h4>
                                <p class="text-sm text-blue-700 mt-1">
                                    The new user will receive an email verification link after account creation.
                                </p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4 mt-4">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <i class="fas fa-key text-yellow-400"></i>
                            </div>
                            <div class="ml-3">
                                <h4 class="text-sm font-medium text-yellow-800">User can change password after login</h4>
                                <p class="text-sm text-yellow-700 mt-1">
                                    Users will be able to update their password from their profile settings.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Help & Guidelines -->
                <div class="border-t border-gray-200 pt-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4 flex items-center">
                        <i class="fas fa-question-circle text-gray-400 mr-2"></i>
                        Help & Guidelines
                    </h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="bg-gray-50 rounded-lg p-4">
                            <h4 class="text-sm font-medium text-gray-900 mb-2 flex items-center">
                                <i class="fas fa-user text-blue-500 mr-2"></i>
                                User Role
                            </h4>
                            <ul class="text-sm text-gray-600 space-y-1">
                                <li>• Can create, edit, and delete their own tasks</li>
                                <li>• Can view their own profile and tasks</li>
                                <li>• Cannot access admin features</li>
                            </ul>
                        </div>
                        
                        <div class="bg-gray-50 rounded-lg p-4">
                            <h4 class="text-sm font-medium text-gray-900 mb-2 flex items-center">
                                <i class="fas fa-crown text-purple-500 mr-2"></i>
                                Admin Role
                            </h4>
                            <ul class="text-sm text-gray-600 space-y-1">
                                <li>• All user permissions</li>
                                <li>• Can manage all users and tasks</li>
                                <li>• Access to admin dashboard and reports</li>
                            </ul>
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="flex items-center justify-between pt-6 border-t border-gray-200">
                    <div class="flex items-center space-x-3">
                        <x-button type="primary" size="lg" buttonType="submit">
                            <i class="fas fa-user-plus mr-2"></i>Create User
                        </x-button>
                        <x-button type="secondary" variant="outline" href="{{ route('users.index') }}">
                            <i class="fas fa-times mr-2"></i>Cancel
                        </x-button>
                    </div>
                    
                    <x-button type="secondary" variant="ghost" buttonType="reset">
                        <i class="fas fa-redo mr-2"></i>Reset Form
                    </x-button>
                </div>
            </form>
        </x-card>
    </div>
</x-app-layout>
