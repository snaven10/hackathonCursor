@props(['title' => null, 'gradient' => false])

@php
    $baseClasses = 'bg-white rounded-2xl shadow-lg overflow-hidden hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-1';
    
    if($gradient) {
        $baseClasses = 'relative bg-gradient-to-br from-white to-gray-50 rounded-2xl shadow-xl overflow-hidden hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-1';
    }
@endphp

<div {{ $attributes->merge(['class' => $baseClasses]) }}>
    @if($gradient)
        <div class="absolute top-0 right-0 w-40 h-40 bg-gradient-to-br from-indigo-500/10 to-purple-500/10 rounded-bl-full"></div>
    @endif
    
    @if($title)
        <div class="px-6 py-4 border-b border-gray-100 relative">
            <h3 class="text-lg font-bold text-gray-800">{{ $title }}</h3>
        </div>
    @endif
    
    <div class="p-6 relative">
        {{ $slot }}
    </div>
</div>

