<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div class="flex items-center space-x-3">
                <div class="w-8 h-8 bg-gradient-to-br from-green-500 to-green-600 rounded-lg flex items-center justify-center">
                    <i class="fas fa-plus text-white text-sm"></i>
                </div>
                <div>
                    <h2 class="text-2xl font-bold text-gray-900">Create New Task</h2>
                    <p class="text-sm text-gray-500">Add a new task to your project</p>
                </div>
            </div>
            <x-button type="secondary" variant="outline" href="{{ route('tasks.index') }}">
                <i class="fas fa-arrow-left mr-2"></i>Back to Tasks
            </x-button>
        </div>
    </x-slot>

    <div class="max-w-4xl mx-auto">
        <x-card title="Task Details" icon="fas fa-edit">
            <form method="POST" action="{{ route('tasks.store') }}" class="space-y-6">
                @csrf
                
                <!-- Basic Information -->
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                    <div class="lg:col-span-2">
                        <x-form-input 
                            name="title" 
                            label="Task Title" 
                            placeholder="Enter task title..."
                            value="{{ old('title') }}"
                            icon="fas fa-heading"
                            required="true"
                            error="{{ $errors->first('title') }}"
                        />
                    </div>
                    
                    <div class="lg:col-span-2">
                        <x-form-input 
                            type="textarea" 
                            name="description" 
                            label="Description" 
                            placeholder="Describe the task in detail..."
                            value="{{ old('description') }}"
                            required="true"
                            error="{{ $errors->first('description') }}"
                            rows="4"
                        />
                    </div>
                </div>

                <!-- Task Properties -->
                <div class="border-t border-gray-200 pt-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4 flex items-center">
                        <i class="fas fa-cog text-gray-400 mr-2"></i>
                        Task Properties
                    </h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        <x-form-input 
                            type="select" 
                            name="priority" 
                            label="Priority" 
                            icon="fas fa-flag"
                            required="true"
                            error="{{ $errors->first('priority') }}"
                        >
                            <option value="">Select Priority</option>
                            <option value="low" {{ old('priority') == 'low' ? 'selected' : '' }}>
                                🟢 Low Priority
                            </option>
                            <option value="medium" {{ old('priority') == 'medium' ? 'selected' : '' }}>
                                🟡 Medium Priority
                            </option>
                            <option value="high" {{ old('priority') == 'high' ? 'selected' : '' }}>
                                🔴 High Priority
                            </option>
                        </x-form-input>

                        <x-form-input 
                            type="select" 
                            name="status" 
                            label="Status" 
                            icon="fas fa-tasks"
                            error="{{ $errors->first('status') }}"
                        >
                            <option value="pending" {{ old('status', 'pending') == 'pending' ? 'selected' : '' }}>
                                ⏳ Pending
                            </option>
                            <option value="in_progress" {{ old('status') == 'in_progress' ? 'selected' : '' }}>
                                🔄 In Progress
                            </option>
                            <option value="completed" {{ old('status') == 'completed' ? 'selected' : '' }}>
                                ✅ Completed
                            </option>
                        </x-form-input>

                        <x-form-input 
                            type="date" 
                            name="due_date" 
                            label="Due Date" 
                            value="{{ old('due_date') }}"
                            icon="fas fa-calendar"
                            error="{{ $errors->first('due_date') }}"
                            helpText="Optional deadline for this task"
                        />
                    </div>
                </div>

                @if(auth()->user()->isAdmin())
                <!-- Assignment (Admin only) -->
                <div class="border-t border-gray-200 pt-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4 flex items-center">
                        <i class="fas fa-user-plus text-gray-400 mr-2"></i>
                        Task Assignment
                    </h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <x-form-input 
                            type="select" 
                            name="user_id" 
                            label="Assign to User" 
                            icon="fas fa-user"
                            required="true"
                            error="{{ $errors->first('user_id') }}"
                        >
                            <option value="">Select User</option>
                            @foreach($users as $user)
                                <option value="{{ $user->id }}" {{ old('user_id') == $user->id ? 'selected' : '' }}>
                                    {{ $user->name }} ({{ $user->email }})
                                </option>
                            @endforeach
                        </x-form-input>
                    </div>
                </div>
                @endif

                <!-- Action Buttons -->
                <div class="flex items-center justify-between pt-6 border-t border-gray-200">
                    <div class="flex items-center space-x-3">
                        <x-button type="primary" size="lg" buttonType="submit">
                            <i class="fas fa-save mr-2"></i>Create Task
                        </x-button>
                        <x-button type="secondary" variant="outline" href="{{ route('tasks.index') }}">
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