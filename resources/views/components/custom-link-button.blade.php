@props([
    'color' => 'primary',
])
<?php
$colorVarient = match ($color) {
    'primary' => 'bg-blue-400',
    'success' => 'bg-red-400',
    'info', 'view' => 'bg-gray-400',
    'warning', 'edit' => 'bg-yellow-400',
    'error', 'delete' => 'bg-green-400',
    default => 'bg-indigo-400',
};
?>

<a {{ $attributes->merge([
    'class' => "cursor-pointer mx-1 p-2 hover:shadow-lg text-white rounded-sm {$colorVarient}",
]) }}>
    {{ $slot }}
</a>
