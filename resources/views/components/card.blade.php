@props([
    'title' => '',
    'subtitle' => '',
    'icon' => '',
    'actions' => false,
    'padding' => 'p-6'
])

<div {{ $attributes->merge(['class' => 'bg-white rounded-xl shadow-sm border border-gray-200 hover:shadow-md transition-shadow duration-200']) }}>
    @if($title || $icon || $actions)
        <div class="flex items-center justify-between {{ $padding }} border-b border-gray-100">
            <div class="flex items-center space-x-3">
                @if($icon)
                    <div class="w-10 h-10 bg-gradient-to-br from-blue-500 to-blue-600 rounded-lg flex items-center justify-center">
                        <i class="{{ $icon }} text-white"></i>
                    </div>
                @endif
                <div>
                    @if($title)
                        <h3 class="text-lg font-semibold text-gray-900">{{ $title }}</h3>
                    @endif
                    @if($subtitle)
                        <p class="text-sm text-gray-500">{{ $subtitle }}</p>
                    @endif
                </div>
            </div>
            @if($actions)
                <div class="flex items-center space-x-2">
                    {{ $actions }}
                </div>
            @endif
        </div>
    @endif
    
    <div class="{{ $title || $icon || $actions ? $padding : $padding }}">
        {{ $slot }}
    </div>
</div>
