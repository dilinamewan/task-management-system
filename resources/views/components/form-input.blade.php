@props([
    'label' => '',
    'name' => '',
    'type' => 'text',
    'value' => '',
    'placeholder' => '',
    'required' => false,
    'error' => '',
    'helpText' => '',
    'icon' => null
])

<div class="space-y-1">
    @if($label)
        <label for="{{ $name }}" class="block text-sm font-medium text-gray-700">
            {{ $label }}
            @if($required)
                <span class="text-red-500">*</span>
            @endif
        </label>
    @endif
    
    <div class="relative">
        @if($icon)
            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                <i class="{{ $icon }} text-gray-400"></i>
            </div>
        @endif
        
        @if($type === 'textarea')
            <textarea 
                id="{{ $name }}" 
                name="{{ $name }}"
                placeholder="{{ $placeholder }}"
                {{ $required ? 'required' : '' }}
                {{ $attributes->merge(['class' => 'block w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200' . ($icon ? ' pl-10' : '') . ($error ? ' border-red-300 focus:ring-red-500 focus:border-red-500' : '')]) }}
            >{{ old($name, $value) }}</textarea>
        @elseif($type === 'select')
            <select 
                id="{{ $name }}" 
                name="{{ $name }}"
                {{ $required ? 'required' : '' }}
                {{ $attributes->merge(['class' => 'block w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200' . ($icon ? ' pl-10' : '') . ($error ? ' border-red-300 focus:ring-red-500 focus:border-red-500' : '')]) }}
            >
                {{ $slot }}
            </select>
        @else
            <input 
                type="{{ $type }}" 
                id="{{ $name }}" 
                name="{{ $name }}"
                value="{{ old($name, $value) }}"
                placeholder="{{ $placeholder }}"
                {{ $required ? 'required' : '' }}
                {{ $attributes->merge(['class' => 'block w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200' . ($icon ? ' pl-10' : '') . ($error ? ' border-red-300 focus:ring-red-500 focus:border-red-500' : '')]) }}
            />
        @endif
    </div>
    
    @if($error)
        <p class="text-sm text-red-600 flex items-center">
            <i class="fas fa-exclamation-circle mr-1"></i>
            {{ $error }}
        </p>
    @endif
    
    @if($helpText && !$error)
        <p class="text-sm text-gray-500">{{ $helpText }}</p>
    @endif
</div>
