@props(['type' => 'primary', 'size' => 'md', 'href' => null, 'disabled' => false])

@php
    $colors = [
        'primary' => 'bg-purple-700 text-white hover:bg-purple-800',
        'secondary' => 'bg-white text-gray-900 border border-gray-200 hover:bg-gray-50',
        'danger' => 'bg-red-600 text-white hover:bg-red-700',
    ];
    $sizes = [
        'sm' => 'px-3 py-2 text-sm',
        'md' => 'px-5 py-3 text-base',
        'lg' => 'px-6 py-4 text-lg',
    ];
    $classes = trim(($colors[$type] ?? $colors['primary']).' '.($sizes[$size] ?? $sizes['md']).' rounded-lg font-semibold transition disabled:opacity-50 disabled:cursor-not-allowed');
@endphp

@if ($href)
    <a href="{{ $href }}" {{ $disabled ? 'aria-disabled=true' : '' }} class="{{ $classes }} {{ $disabled ? 'pointer-events-none' : '' }}">
        {{ $slot }}
    </a>
@else
    <button {{ $disabled ? 'disabled' : '' }} class="{{ $classes }}">
        {{ $slot }}
    </button>
@endif
