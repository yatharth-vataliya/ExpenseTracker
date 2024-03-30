@props([
    'optionsData' => [],
])
<select
    {{ $attributes->merge([
        'class' => 'border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm w-full invalid:border-green-500 valid:border-red-500',
    ]) }}>
    <option value="" disabled selected>None</option>
    @foreach ($optionsData as $key => $option)
        <option wire:key="{{ $key }}" value="{{ $option->{$valueField} }}">
            {{ $option->{$textField} }}
        </option>
    @endforeach
</select>
