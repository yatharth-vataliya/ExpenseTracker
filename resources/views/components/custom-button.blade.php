<button
    {{ $attributes->merge([
        'type' => 'button',
        'class' =>
            'p-2 hover:shadow-lg bg-black text-white rounded disabled:bg-gray-500 disabled:hover:shadow-none disabled:cursor-not-allowed',
    ]) }}>
    {{ $slot }}
</button>
