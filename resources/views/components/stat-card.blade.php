@props([
    'label' => '',
    'value' => '',
    'change' => null,
    'changeType' => 'positive', // positive, negative, neutral
    'icon' => '',
    'color' => 'blue'
])

@php
    $colorClasses = [
        'blue' => 'from-blue-500 to-blue-600',
        'green' => 'from-green-500 to-green-600',
        'yellow' => 'from-yellow-500 to-yellow-600',
        'red' => 'from-red-500 to-red-600',
        'purple' => 'from-purple-500 to-purple-600',
        'indigo' => 'from-indigo-500 to-indigo-600',
    ];
    
    $changeClasses = [
        'positive' => 'text-green-600 bg-green-50',
        'negative' => 'text-red-600 bg-red-50',
        'neutral' => 'text-gray-600 bg-gray-50'
    ];
@endphp

<div {{ $attributes->merge(['class' => 'bg-white rounded-xl shadow-sm border border-gray-200 p-6 hover:shadow-md transition-shadow duration-200']) }}>
    <div class="flex items-center justify-between">
        <div class="flex-1">
            <p class="text-sm font-medium text-gray-600 mb-1">{{ $label }}</p>
            <p class="text-3xl font-bold text-gray-900">{{ $value }}</p>
            
            @if($change !== null)
                <div class="flex items-center mt-2">
                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium {{ $changeClasses[$changeType] }}">
                        @if($changeType === 'positive')
                            <i class="fas fa-arrow-up mr-1"></i>
                        @elseif($changeType === 'negative')
                            <i class="fas fa-arrow-down mr-1"></i>
                        @endif
                        {{ $change }}
                    </span>
                    <span class="text-sm text-gray-500 ml-2">from last month</span>
                </div>
            @endif
        </div>
        
        @if($icon)
            <div class="w-12 h-12 bg-gradient-to-br {{ $colorClasses[$color] }} rounded-lg flex items-center justify-center">
                <i class="{{ $icon }} text-white text-lg"></i>
            </div>
        @endif
    </div>
</div>
