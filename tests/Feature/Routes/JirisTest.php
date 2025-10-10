<?php

use App\Models\Jiri;

use function Pest\Laravel\post;

it('redirects to the jiri index route after the successful creation of a Jiri', function () {

    // Arrange
    $jiri = Jiri::factory()->raw();

    // Act
    $response = post(route('jiris.store'), $jiri);

    // Assert
    $response->assertStatus(302);
    $response->assertRedirect('/jiris');
});

it('display a complete list of jiris on the jiri index page', function () {
    $jiris = Jiri::factory(4)->create();

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
    $jiri = Jiri::factory()->create();

    // Act
    $response = $this->get('/jiris/'.$jiri->id);

    // Assert
    $response->assertStatus(200);
    $response->assertViewIs('jiris.show');
    $response->assertSee('Récapitulatif du jiri : '.$jiri->name);
});

it('validate informations about a new jiri', function () {
    $jiri = ['name' => '', 'date' => ''];

    $response = $this->post('/jiris', $jiri);

    $response->assertInvalid('name');
    $response->assertInvalid('date');
});
