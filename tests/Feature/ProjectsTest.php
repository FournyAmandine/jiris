<?php

use App\Models\Project;

use App\Models\User;
use function Pest\Laravel\assertDatabaseHas;

it('creates a project and redirects to the project index', function () {

    $project = ['name' => 'Client'];

    $response = $this->post('/projects', $project);
    $response->assertStatus(302);
    $response->assertRedirect('/projects');
    assertDatabaseHas('projects', ['name' => 'Client']);
});

it('display a complete list of projects on the contact index page', function () {
    $projects = Project::factory(4)->create();

    $response = $this->get('/projects');

    $response->assertStatus(200);
    $response->assertViewIs('projects.index');
    $response->assertSee('Liste des projets');

    foreach ($projects as $project) {
        $response->assertSee($project['name']);
    }
});

it('check if the project dashboard link corresponds to the correct project', function () {
    // Arrange
    $project = Project::factory()->create();

    // Act
    $response = $this->get('/projects/'.$project->id);

    // Assert
    $response->assertStatus(200);
    $response->assertViewIs('projects.show');
    $response->assertSee('Récapitulatif du projet : '.$project->name);
});

it('validate informations about a new project', function () {
    $project = ['name' => ''];


    $response = $this->post('/projects', $project);

    $response->assertInvalid('name');
});
