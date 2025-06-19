<li class="w-full text-center p-2">
    <a href="{{ route($routeName) }}" wire:navigate>
        <span class="p-3 block hover:bg-violet-400 hover:text-white text-black font-bold rounded-sm hover:shadow-md @isActiveRoute($routeName) bg-violet-400 text-white @endisActiveRoute">
           {{ $routeLabel }} 
        </span>
    </a>
</li>