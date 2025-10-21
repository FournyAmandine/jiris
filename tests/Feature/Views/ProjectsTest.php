<?php


use App\Models\User;
use function Pest\Laravel\get;

it(
    'verifies that the projects.create route displays a form to create a Project',
    function (string $locale, string $main_heading) {
        App::setLocale($locale);

        $user = User::factory()->create();
        \Pest\Laravel\actingAs($user);


        $response = get(route('projects.create'));

        $response->assertSee("<h1 class=\"font-bold text-4xl my-4 text-center flex flex-col mx-auto\">$main_heading</h1>", false);
    }
)->with([
    ['fr', 'Créez votre projet'],
    ['en', 'Create your project'],
]);


