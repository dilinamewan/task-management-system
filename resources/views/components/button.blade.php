@props([
    'type' => 'primary', // primary, secondary, success, danger, warning, info
    'size' => 'md', // sm, md, lg
    'variant' => 'solid', // solid, outline, ghost
    'icon' => null,
    'loading' => false,
    'href' => null,
    'buttonType' => 'button' // button, submit, reset
])

@php
    $baseClasses = 'inline-flex items-center justify-center font-medium rounded-lg transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-offset-2 no-underline';
    
    $sizeClasses = [
        'sm' => 'px-3 py-1.5 text-sm',
        'md' => 'px-4 py-2 text-sm',
        'lg' => 'px-6 py-3 text-base'
    ];
    
    $typeClasses = [
        'primary' => [
            'solid' => 'bg-blue-600 text-white hover:bg-blue-700 focus:ring-blue-500',
            'outline' => 'border border-blue-600 text-blue-600 hover:bg-blue-50 focus:ring-blue-500',
            'ghost' => 'text-blue-600 hover:bg-blue-50 focus:ring-blue-500'
        ],
        'secondary' => [
            'solid' => 'bg-gray-600 text-white hover:bg-gray-700 focus:ring-gray-500',
            'outline' => 'border border-gray-600 text-gray-600 hover:bg-gray-50 focus:ring-gray-500',
            'ghost' => 'text-gray-600 hover:bg-gray-50 focus:ring-gray-500'
        ],
        'success' => [
            'solid' => 'bg-green-600 text-white hover:bg-green-700 focus:ring-green-500',
            'outline' => 'border border-green-600 text-green-600 hover:bg-green-50 focus:ring-green-500',
            'ghost' => 'text-green-600 hover:bg-green-50 focus:ring-green-500'
        ],
        'danger' => [
            'solid' => 'bg-red-600 text-white hover:bg-red-700 focus:ring-red-500',
            'outline' => 'border border-red-600 text-red-600 hover:bg-red-50 focus:ring-red-500',
            'ghost' => 'text-red-600 hover:bg-red-50 focus:ring-red-500'
        ],
        'warning' => [
            'solid' => 'bg-yellow-600 text-white hover:bg-yellow-700 focus:ring-yellow-500',
            'outline' => 'border border-yellow-600 text-yellow-600 hover:bg-yellow-50 focus:ring-yellow-500',
            'ghost' => 'text-yellow-600 hover:bg-yellow-50 focus:ring-yellow-500'
        ],
        'info' => [
            'solid' => 'bg-indigo-600 text-white hover:bg-indigo-700 focus:ring-indigo-500',
            'outline' => 'border border-indigo-600 text-indigo-600 hover:bg-indigo-50 focus:ring-indigo-500',
            'ghost' => 'text-indigo-600 hover:bg-indigo-50 focus:ring-indigo-500'
        ]
    ];
    
    $classes = $baseClasses . ' ' . $sizeClasses[$size] . ' ' . $typeClasses[$type][$variant];
    
    if ($loading) {
        $classes .= ' opacity-75 cursor-not-allowed';
    }
    
    $tag = $href ? 'a' : 'button';
    $tagAttributes = $href ? ['href' => $href] : ['type' => $buttonType];
@endphp

<{{ $tag }} {{ $attributes->merge(array_merge($tagAttributes, ['class' => $classes, 'disabled' => $loading])) }}>
    @if($loading)
        <svg class="animate-spin -ml-1 mr-2 h-4 w-4" fill="none" viewBox="0 0 24 24">
            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
        </svg>
    @elseif($icon)
        <i class="{{ $icon }} {{ $slot->isEmpty() ? '' : 'mr-2' }}"></i>
    @endif
    
    {{ $slot }}
</{{ $tag }}>
