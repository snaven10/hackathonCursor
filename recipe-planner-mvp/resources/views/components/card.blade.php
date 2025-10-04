@props(['title' => null])

<div {{ $attributes->merge(['class' => 'bg-white rounded-xl shadow-md overflow-hidden hover:shadow-lg transition-shadow duration-300']) }}>
    @if($title)
        <div class="px-6 py-4 border-b border-gray-200">
            <h3 class="text-lg font-semibold text-gray-800">{{ $title }}</h3>
        </div>
    @endif
    
    <div class="p-6">
        {{ $slot }}
    </div>
</div>

