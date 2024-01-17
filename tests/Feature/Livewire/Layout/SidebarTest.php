<?php

use App\Livewire\Layout\Sidebar;
use Livewire\Livewire;

it('Sidebar renders successfully', function () {
    Livewire::test(Sidebar::class)
        ->assertStatus(200);
});
