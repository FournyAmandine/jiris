<?php

use function Pest\Laravel\get;

it(
    'verifies that the jiris.create route displays a form to create a Jiri',
    function (string $locale, string $main_heading) {

        App::setLocale($locale);

        $response = get(route('jiris.create'));

        $response->assertSee("<h1>$main_heading</h1>", false);
    }
)->with([
    ['fr', 'Créez votre jiri'],
    ['en', 'Create your jiri'],
]);

/*it('displays an error message when the name is missing',
    function (string $locale) {
    \Illuminate\Support\Facades\App::setLocale($locale);
    $response = get()
    }
);*/
