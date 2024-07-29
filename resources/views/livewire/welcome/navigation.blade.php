<div class="sm:fixed p-6 text-right z-10 dark:bg-black rounded">
    @auth
        <a href="{{ url('/dashboard') }}"
            class="font-semibold text-gray-600 hover:text-gray-900 focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500"
            wire:navigate>Dashboard</a>
    @else
        <a href="{{ route('login') }}"
            class="font-semibold text-gray-600 hover:text-gray-900 focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500"
            wire:navigate>Log in</a>

        @if (Route::has('register'))
            <a href="{{ route('register') }}"
                class="ml-4 font-semibold text-gray-600 hover:text-gray-900 focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500"
                wire:navigate>Register</a>
        @endif
    @endauth
</div>
