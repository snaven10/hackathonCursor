@props(['type' => 'primary', 'href' => null])

@php
    $classes = [
        'primary' => 'bg-indigo-600 hover:bg-indigo-700 text-white',
        'secondary' => 'bg-gray-600 hover:bg-gray-700 text-white',
        'danger' => 'bg-red-600 hover:bg-red-700 text-white',
        'success' => 'bg-green-600 hover:bg-green-700 text-white',
    ];
    
    $baseClasses = 'inline-flex items-center px-4 py-2 border border-transparent rounded-md font-semibold text-sm focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition ease-in-out duration-150';
@endphp

@if($href)
    <a href="{{ $href }}" {{ $attributes->merge(['class' => $baseClasses . ' ' . ($classes[$type] ?? $classes['primary'])]) }}>
        {{ $slot }}
    </a>
@else
    <button {{ $attributes->merge(['class' => $baseClasses . ' ' . ($classes[$type] ?? $classes['primary']), 'type' => 'button']) }}>
        {{ $slot }}
    </button>
@endif

