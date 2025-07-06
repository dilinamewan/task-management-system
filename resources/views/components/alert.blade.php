@props([
    'type' => 'info', // success, error, warning, info
    'title' => '',
    'dismissible' => true,
    'icon' => null
])

@php
    $typeClasses = [
        'success' => 'bg-green-50 border-green-200 text-green-800',
        'error' => 'bg-red-50 border-red-200 text-red-800',
        'warning' => 'bg-yellow-50 border-yellow-200 text-yellow-800',
        'info' => 'bg-blue-50 border-blue-200 text-blue-800'
    ];
    
    $iconClasses = [
        'success' => 'fas fa-check-circle text-green-400',
        'error' => 'fas fa-exclamation-circle text-red-400',
        'warning' => 'fas fa-exclamation-triangle text-yellow-400',
        'info' => 'fas fa-info-circle text-blue-400'
    ];
    
    $defaultIcon = $icon ?: $iconClasses[$type];
@endphp

<div {{ $attributes->merge(['class' => 'border rounded-lg p-4 ' . $typeClasses[$type] . ' animate-fade-in']) }}>
    <div class="flex">
        <div class="flex-shrink-0">
            <i class="{{ $defaultIcon }}"></i>
        </div>
        <div class="ml-3 flex-1">
            @if($title)
                <h3 class="text-sm font-medium mb-1">{{ $title }}</h3>
            @endif
            <div class="text-sm">
                {{ $slot }}
            </div>
        </div>
        @if($dismissible)
            <div class="ml-auto pl-3">
                <div class="-mx-1.5 -my-1.5">
                    <button onclick="this.closest('.border').remove()" class="inline-flex rounded-md p-1.5 hover:bg-black hover:bg-opacity-10 transition-colors duration-200">
                        <i class="fas fa-times text-sm"></i>
                    </button>
                </div>
            </div>
        @endif
    </div>
</div>
