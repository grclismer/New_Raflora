@props(['label' => null, 'name', 'value' => '1', 'checked' => false, 'error' => null])

<div class="flex items-start gap-3">
    <input
        id="{{ $name }}"
        name="{{ $name }}"
        type="checkbox"
        value="{{ $value }}"
        {{ $checked ? 'checked' : '' }}
        class="mt-1 h-4 w-4 rounded border-gray-300 text-purple-600 focus:ring-purple-500"
    />
    <div class="text-sm">
        @if($label)
            <label for="{{ $name }}" class="font-medium text-gray-700">{{ $label }}</label>
        @endif
        @if($error)
            <p class="text-sm text-red-600">{{ $error }}</p>
        @endif
    </div>
</div>
