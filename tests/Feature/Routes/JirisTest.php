<?php

use App\Models\Jiri;

use App\Models\User;
use function Pest\Laravel\actingAs;
use function Pest\Laravel\post;

it('redirects to the jiri show route after the successful creation of a Jiri', function () {

    // Arrange
    $user = User::factory()
        ->create();
    actingAs($user);


    $jiri = Jiri::factory()
        ->for(auth()->user())
        ->raw();

    // Act
    $response = post(route('jiris.store'), $jiri);
    $jiri = Jiri::first();
    // Assert
    $response->assertStatus(302);
    $response->assertRedirect(route('jiris.show', $jiri->id));
});

it('display a complete list of jiris on the jiri index page', function () {
    $user = User::factory()
        ->create();
    actingAs($user);

    $jiris = Jiri::factory(4)
        ->for(auth()->user())
        ->create();


    $response = $this->get('/jiris');

    $response->assertStatus(200);
    $response->assertViewIs('jiris.index');
    $response->assertSee('Liste des jiris');

    foreach ($jiris as $jiri) {
        $response->assertSee($jiri['name']);
    }
});

it('check if the jiri dashboard link corresponds to the correct jiri', function () {
    // Arrange
    $user = User::factory()
        ->create();
    actingAs($user);

    $jiri = Jiri::factory()
        ->for(auth()->user())
        ->create();


    // Act
    $response = $this->get('/jiris/'.$jiri->id);

    // Assert
    $response->assertStatus(200);
    $response->assertViewIs('jiris.show');
    $response->assertSee('Récapitulatif du jiri : '.$jiri->name);
});

it('validate informations about a new jiri', function () {
    $user = User::factory()
        ->create();
    $jiri = ['name' => '', 'date' => ''];

    actingAs($user);

    $response = $this->post('/jiris', $jiri);

    $response->assertInvalid('name');
    $response->assertInvalid('date');
});
