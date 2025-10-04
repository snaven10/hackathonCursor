@props(['type' => 'success', 'message'])

@php
    $classes = [
        'success' => 'bg-green-50 border-green-200 text-green-800',
        'error' => 'bg-red-50 border-red-200 text-red-800',
        'warning' => 'bg-yellow-50 border-yellow-200 text-yellow-800',
        'info' => 'bg-blue-50 border-blue-200 text-blue-800',
    ];
    
    $icons = [
        'success' => '✓',
        'error' => '✕',
        'warning' => '⚠',
        'info' => 'ℹ',
    ];
@endphp

<div {{ $attributes->merge(['class' => 'flex items-center p-4 border rounded-lg ' . ($classes[$type] ?? $classes['info'])]) }} role="alert">
    <span class="text-xl mr-3">{{ $icons[$type] ?? $icons['info'] }}</span>
    <span class="text-sm font-medium">{{ $message }}</span>
</div>

