<?php

use App\Models\Project;
use App\Models\User;
use function Pest\Laravel\assertDatabaseHas;

beforeEach(function(){
    $user = User::factory()->create();
    \Pest\Laravel\actingAs($user);
});


it('creates successfully a Project from the data provided by the request', function () {

    // Arrange
    $project = Project::factory()->raw();


    // Act
    $response = $this->post(route('projects.index'), $project);

    // Assert
    assertDatabaseHas('projects', ['name' => $project['name']]);

});

it('display a complete list of projects on the contact index page', function () {

    $projects = Project::factory(4)
        ->for(auth()->user())
        ->create();

    $response = $this->get(route('projects.index'));

    $response->assertStatus(200);
    $response->assertViewIs('projects.index');
    $response->assertSee('Mes projets');

    foreach ($projects as $project) {
        $response->assertSee($project['name']);
    }
});
