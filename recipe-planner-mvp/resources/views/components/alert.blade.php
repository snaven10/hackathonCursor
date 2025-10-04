@props(['type' => 'success', 'message'])

@php
    $classes = [
        'success' => 'bg-emerald-50 border-emerald-200 text-emerald-800',
        'error' => 'bg-rose-50 border-rose-200 text-rose-800',
        'warning' => 'bg-amber-50 border-amber-200 text-amber-800',
        'info' => 'bg-blue-50 border-blue-200 text-blue-800',
    ];
    
    $icons = [
        'success' => '✓',
        'error' => '✕',
        'warning' => '⚠',
        'info' => 'ℹ',
    ];
@endphp

<div {{ $attributes->merge(['class' => 'flex items-center p-4 border rounded-xl shadow-sm ' . ($classes[$type] ?? $classes['info'])]) }} role="alert">
    <div class="flex-shrink-0 w-8 h-8 flex items-center justify-center rounded-full {{ $type === 'success' ? 'bg-emerald-200' : ($type === 'error' ? 'bg-rose-200' : ($type === 'warning' ? 'bg-amber-200' : 'bg-blue-200')) }} mr-3">
        <span class="text-lg font-bold">{{ $icons[$type] ?? $icons['info'] }}</span>
    </div>
    <span class="text-sm font-medium flex-1">{{ $message }}</span>
</div>

