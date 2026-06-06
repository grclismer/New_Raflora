@props(['variant' => 'primary', 'class' => ''])

@php
    $colors = [
        'primary' => 'bg-purple-100 text-purple-800',
        'success' => 'bg-emerald-100 text-emerald-800',
        'warning' => 'bg-amber-100 text-amber-800',
        'danger' => 'bg-red-100 text-red-800',
        'neutral' => 'bg-gray-100 text-gray-800',
    ];
    $colorClass = $colors[$variant] ?? $colors['primary'];
@endphp

<span class="inline-flex items-center rounded-full px-3 py-1 text-sm font-semibold {{ $colorClass }} {{ $class }}">
    {{ $slot }}
</span>
