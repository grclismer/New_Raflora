@props(['label' => null, 'name', 'options' => [], 'value' => null, 'error' => null])

<div class="space-y-3">
    @if($label)
        <p class="text-sm font-semibold text-gray-700">{{ $label }}</p>
    @endif
    <div class="space-y-2">
        @foreach($options as $optionValue => $optionLabel)
            <label class="flex items-center gap-3 text-sm text-gray-700">
                <input type="radio" name="{{ $name }}" value="{{ $optionValue }}" {{ old($name, $value) == $optionValue ? 'checked' : '' }} class="h-4 w-4 text-purple-600 border-gray-300 focus:ring-purple-500">
                <span>{{ $optionLabel }}</span>
            </label>
        @endforeach
    </div>
    @if($error)
        <p class="text-sm text-red-600">{{ $error }}</p>
    @endif
</div>
