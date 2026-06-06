@props(['label' => null, 'name', 'value' => '', 'placeholder' => '', 'required' => false, 'error' => null])

<div class="space-y-2">
    @if($label)
        <label for="{{ $name }}" class="block text-sm font-semibold text-gray-700">{{ $label }}</label>
    @endif
    <textarea
        id="{{ $name }}"
        name="{{ $name }}"
        rows="4"
        placeholder="{{ $placeholder }}"
        {{ $required ? 'required' : '' }}
        class="w-full rounded-xl border border-gray-200 px-4 py-3 focus:border-purple-500 focus:ring-2 focus:ring-purple-100 transition"
    >{{ old($name, $value) }}</textarea>
    @if($error)
        <p class="text-sm text-red-600">{{ $error }}</p>
    @endif
</div>
