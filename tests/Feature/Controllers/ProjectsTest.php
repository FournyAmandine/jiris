<?php

use App\Models\Project;
use App\Models\User;
use function Pest\Laravel\actingAs;
use function Pest\Laravel\assertDatabaseHas;
use function Pest\Laravel\assertDatabaseMissing;

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

it('check if the project dashboard correspond to the correct project', function () {
    $project = Project::factory()
        ->for(auth()->user())
        ->create();

    $response = $this->get(route('projects.show',$project->id));

    $response->assertStatus(200);
    $response->assertViewIs('projects.show');
    $response->assertSee($project->name);
});

it('fails to create a new project in the database when the name is missing in the request and validate the informations', function () {

    $project = Project::factory()
        ->withoutName()
        ->raw();


    $response = $this->post(route('projects.store'), $project);

    $response->assertInvalid('name');

    \Pest\Laravel\assertDatabaseEmpty('projects');


});

it('the user is successfully taken to the projects.show view', function () {

    $project = Project::factory()->for(auth()->user())->create();


    $response = $this->get(route('projects.show', $project->id));

    $response->assertStatus(200);
    $response->assertViewIs('projects.show');
    $response->assertSee($project->name);
});

it('the projects.edit view exists', function () {

    $project = Project::factory()->for(auth()->user())->create();


    $response = $this->get(route('projects.edit', $project->id));

    $response->assertStatus(200);
    $response->assertViewIs('projects.edit');
    $response->assertSee('Modifiez votre projet');
});

it('verifies if the user can modified his contact and if it is correctly saved in the database', function () {

    $project = Project::factory()->for(auth()->user())->create();

    $new_project = [
        'name' => 'CV',
    ];

    $response = $this->patch(route('projects.update', $project->id), $new_project);

    assertDatabaseMissing('projects', [
        'name' =>$project->name,
    ]);

    assertDatabaseHas('projects', [
        'name' =>$new_project['name'],
    ]);


});
