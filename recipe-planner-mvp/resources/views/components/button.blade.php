@props(['variant' => 'primary', 'href' => null])

@php
    $classes = [
        'primary' => 'bg-emerald-500 hover:bg-emerald-600 text-white shadow-md hover:shadow-lg',
        'secondary' => 'bg-gray-600 hover:bg-gray-700 text-white shadow-md hover:shadow-lg',
        'danger' => 'bg-rose-500 hover:bg-rose-600 text-white shadow-md hover:shadow-lg',
        'success' => 'bg-green-500 hover:bg-green-600 text-white shadow-md hover:shadow-lg',
        'outline' => 'bg-white border-2 border-emerald-500 text-emerald-600 hover:bg-emerald-50',
    ];
    
    $baseClasses = 'inline-flex items-center px-4 py-2.5 border border-transparent rounded-lg font-semibold text-sm focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-emerald-500 transition-all duration-200 ease-in-out';
@endphp

@if($href)
    <a href="{{ $href }}" {{ $attributes->merge(['class' => $baseClasses . ' ' . ($classes[$variant] ?? $classes['primary'])]) }}>
        {{ $slot }}
    </a>
@else
    <button {{ $attributes->merge(['class' => $baseClasses . ' ' . ($classes[$variant] ?? $classes['primary']), 'type' => 'button']) }}>
        {{ $slot }}
    </button>
@endif

