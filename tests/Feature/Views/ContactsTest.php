<?php

use App\Models\User;
use function Pest\Laravel\actingAs;
use function Pest\Laravel\get;

it(
    'verifies that the jiris.create route displays a form to create a Jiri',
    function (string $locale, string $main_heading) {
        App::setLocale($locale);

        $user = User::factory()->create();
        actingAs($user);


        $response = get(route('contacts.create'));

        $response->assertSee("<h1 class=\"font-bold text-4xl my-4 text-center flex flex-col mx-auto\">$main_heading</h1>", false);
    }
)->with([
    ['fr', 'Créez un contact'],
    ['en', 'Create a contact'],
]);
