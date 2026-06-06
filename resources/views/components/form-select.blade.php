@props(['label' => null, 'name', 'options' => [], 'value' => '', 'placeholder' => null, 'required' => false, 'error' => null])

<div class="space-y-2">
    @if($label)
        <label for="{{ $name }}" class="block text-sm font-semibold text-gray-700">{{ $label }}</label>
    @endif
    <select
        id="{{ $name }}"
        name="{{ $name }}"
        {{ $required ? 'required' : '' }}
        class="w-full rounded-xl border border-gray-200 bg-white px-4 py-3 focus:border-purple-500 focus:ring-2 focus:ring-purple-100 transition"
    >
        @if($placeholder)
            <option value="">{{ $placeholder }}</option>
        @endif
        @foreach($options as $optionValue => $optionLabel)
            <option value="{{ $optionValue }}" {{ old($name, $value) == $optionValue ? 'selected' : '' }}>{{ $optionLabel }}</option>
        @endforeach
    </select>
    @if($error)
        <p class="text-sm text-red-600">{{ $error }}</p>
    @endif
</div>
