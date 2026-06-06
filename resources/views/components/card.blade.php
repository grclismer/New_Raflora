@props(['title' => null, 'subtitle' => null, 'class' => ''])

<div class="rounded-3xl bg-white/70 border border-purple-100 shadow-lg backdrop-blur-sm p-6 {{ $class }}">
    @if($title)
        <div class="mb-4">
            <h2 class="text-xl font-semibold text-purple-900">{{ $title }}</h2>
            @if($subtitle)
                <p class="text-sm text-gray-600">{{ $subtitle }}</p>
            @endif
        </div>
    @endif
    {{ $slot }}
</div>
