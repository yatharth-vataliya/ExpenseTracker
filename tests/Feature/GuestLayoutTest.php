<?php

namespace Tests\Feature;

use Tests\TestCase;

class GuestLayoutTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_for_guest_layout(): void
    {
        $response = $this->get('/login');

        $response->assertStatus(200);

        $this->assertGuest('web');

        $view = $this->view('layouts.guest', ['slot' => 'Guest Layout']);

        $view->assertSee('Guest Layout');

    }

    public function test_for_guest_layout_v2(): void
    {
        $view = $this->blade('layouts.guest', ['slot' => 'slot content']);

        $view->assertDontSeeText('login');
    }
}
