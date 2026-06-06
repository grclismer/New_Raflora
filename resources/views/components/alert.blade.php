@props(['type' => 'info'])

@php
    $colors = [
        'info' => 'bg-blue-50 border-blue-200 text-blue-800',
        'success' => 'bg-emerald-50 border-emerald-200 text-emerald-800',
        'warning' => 'bg-amber-50 border-amber-200 text-amber-800',
        'danger' => 'bg-red-50 border-red-200 text-red-800',
    ];
    $colorClass = $colors[$type] ?? $colors['info'];
@endphp

<div class="rounded-2xl border px-5 py-4 {{ $colorClass }}">
    {{ $slot }}
</div>
