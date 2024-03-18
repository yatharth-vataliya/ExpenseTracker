@props([
    'color' => '',
])
<?php
$colorVarient = match ($color) {
    'primary' => 'bg-blue-400',
    'success' => 'bg-red-400',
    'info', 'view' => 'bg-gray-400',
    'warning', 'edit' => 'bg-yellow-400',
    'error', 'delete' => 'bg-green-400',
    default => 'bg-black',
};
?>
<button
    {{ $attributes->merge([
        'type' => 'button',
        'class' => "p-2 hover:shadow-lg text-white rounded disabled:bg-gray-500 disabled:hover:shadow-none disabled:cursor-not-allowed {$colorVarient}",
    ]) }}>
    {{ $slot }}
</button>
