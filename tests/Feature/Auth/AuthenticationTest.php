<?php

use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Lockout;
use Illuminate\Support\Facades\Event;
use Laravel\Sanctum\Sanctum;
use Livewire\Volt\Volt;

test('login screen can be rendered', function () {
    $response = $this->get('/login');

    $response
        ->assertSeeVolt('pages.auth.login')
        ->assertOk();
});

test('users can authenticate using the login screen', function () {
    $user = User::factory()->create();

    $component = Volt::test('pages.auth.login')
        ->set('form.email', $user->email)
        ->set('form.password', 'password');

    $component->call('login');

    $component
        ->assertHasNoErrors()
        ->assertRedirect(RouteServiceProvider::HOME);

    $this->assertAuthenticated();
});

test('users can not authenticate with invalid password', function () {
    $user = User::factory()->create();

    $component = Volt::test('pages.auth.login')
        ->set('form.email', $user->email)
        ->set('form.password', 'wrong-password');

    $component->call('login');

    $component
        ->assertHasErrors()
        ->assertNoRedirect();

    $this->assertGuest();
});

test('navigation menu can be rendered', function () {
    $user = User::factory()->create();

    $this->actingAs($user);

    $response = $this->get('/dashboard');

    $response
        ->assertSeeVolt('layout.navigation')
        ->assertOk();
});

test('users can logout', function () {
    $user = User::factory()->create();

    $this->actingAs($user);

    $component = Volt::test('layout.navigation');

    $component->call('logout');

    $component
        ->assertHasNoErrors()
        ->assertRedirect('/');

    $this->assertGuest();
});

test('user will redirected if already login', function () {
    $this->actingAs(User::factory()->create());

    $response = $this->get('/login');

    $response->assertStatus(302)->assertRedirect(RouteServiceProvider::HOME);
});

test('test max login attempt by a user in 1 minutes', function () {
    $email = 'wrongemail@gmail.com';
    $component = Volt::test('pages.auth.login')
        ->set('form.email', $email)
        ->set('form.password', 'password');

    $component->call('login');

    $component->assertHasErrors(['email' => [trans('auth.failed')]]);

    $this->assertGuest();

    $component = $component->call('login');

    $component->assertHasErrors(['email' => [trans('auth.failed')]]);

    $this->assertGuest();

    $component = $component->call('login');

    $component->assertHasErrors(['email' => [trans('auth.failed')]]);

    $this->assertGuest();

    $component = $component->call('login');

    $component->assertHasErrors(['email' => [trans('auth.failed')]]);

    $this->assertGuest();

    $component = $component->call('login');

    $component->assertHasErrors(['email' => [trans('auth.failed')]]);

    $this->assertGuest();

    Event::fake();

    $component = $component->call('login');

    Event::assertDispatched(Lockout::class);

    Event::assertDispatched(Lockout::class, function ($event) {
        return $event->request == request();
    });

    $component->assertHasErrors(['email']);

    $this->assertGuest();
});

test('check if API is working with valid credentials', function () {
    Sanctum::actingAs(User::factory()->create());

    $response = $this->get('/api/user');

    $response->assertOk();
});
