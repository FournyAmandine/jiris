<?php

use App\Enums\ContactRoles;
use App\Models\Attendance;
use App\Models\Contact;
use App\Models\Homework;
use App\Models\Implementation;
use App\Models\Jiri;

use App\Models\Project;
use App\Models\User;
use function Pest\Laravel\assertDatabaseHas;


beforeEach(function(){
    $user = User::factory()->create();
    \Pest\Laravel\actingAs($user);
});

it('creates successfully a Jiri from the data provided by the request', function () {

    // Arrange
    $user = User::factory()->create();
    $jiri = Jiri::factory()->raw();

    \Pest\Laravel\actingAs($user);

    // Act
    $response = $this->post('/jiris', $jiri);

    // Assert
    assertDatabaseHas('jiris', ['name' => $jiri['name']]);
    //assertDatabaseHas('jiris', $jiri);

});

it(
    'fails to create a new jiri in database when the name is missing in the request',
    function () {

        $user = User::factory()->create();
        $jiri = Jiri::factory()
            ->withoutName()
            ->raw();

        \Pest\Laravel\actingAs($user);
        $response = $this->post(route('jiris.store'), $jiri);
        $response->assertInvalid('name');
        //expect($response)->toThrow(\Illuminate\Database\QueryException::class);

        \Pest\Laravel\assertDatabaseEmpty('jiris');

    }
);

it(
    'fails to create a new jiri in database when the date is missing in the request',
    function () {
        $user = User::factory()->create();

        $jiri = Jiri::factory()
            ->withoutDate()
            ->raw();

        \Pest\Laravel\actingAs($user);
        $response = $this->post(route('jiris.store'), $jiri);
        $response->assertInvalid('date');
        //expect($response)->toThrow(\Illuminate\Database\QueryException::class);

        \Pest\Laravel\assertDatabaseEmpty('jiris');

    }
);


it(
    'fails to create a new jiri in database when the date has the wrong format in the request',
    function () {

        $user = User::factory()->create();
        $jiri = Jiri::factory()
            ->withWrongDate()
            ->raw();
        \Pest\Laravel\actingAs($user);
        $response = $this->post(route('jiris.store'), $jiri);
        $response->assertInvalid('date');
        //expect($response)->toThrow(\Illuminate\Database\QueryException::class);

        \Pest\Laravel\assertDatabaseEmpty('jiris');

    }
);


it('display a complete list of jiris on the jiri index page', function () {
    $user = User::factory()->create();
    $jiris = Jiri::factory(4)->create();

    \Pest\Laravel\actingAs($user);

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
    $user = User::factory()->create();
    $jiri = Jiri::factory()->create();

    \Pest\Laravel\actingAs($user);

    // Act
    $response = $this->get('/jiris/' . $jiri->id);

    // Assert
    $response->assertStatus(200);
    $response->assertViewIs('jiris.show');
    $response->assertSee('Récapitulatif du jiri : ' . $jiri->name);
});

it('validate informations about a new jiri', function () {
    $user = User::factory()->create();
    $jiri = ['name' => '', 'date' => ''];

    \Pest\Laravel\actingAs($user);

    $response = $this->post('/jiris', $jiri);

    $response->assertInvalid('name');
    $response->assertInvalid('date');
});


it('creates a jiri with its projects associated from a request containing jiri data and project ids'
,function(){
    // Homeworks
        $user = User::factory()->create();
        $jiri = Jiri::factory()->raw();
        $projects = Project::factory()
            ->count(2)
            ->create()
            ->pluck('id', 'id')
            ->toArray();

        \Pest\Laravel\actingAs($user);

        $form_data = array_merge($jiri,
            [
                'projects'=>$projects,
            ]);

        $response = $this->post(route('jiris.store'), $form_data);

        expect(Jiri::all()->count())->toBe(1);
        expect(Project::all()->count())->toBe(2);
        expect(Homework::all()->count())->toBe(2);
    });
it('creates a jiri with its contacts associated from a request containing jiri data and contacts ids including their roles'
    ,function(){
    // Attendances
        $user = User::factory()->create();
        $jiri = Jiri::factory()->raw();
        $contacts = Contact::factory()
            ->count(2)
            ->create()
            ->pluck('id', 'id')
            ->toArray();

        \Pest\Laravel\actingAs($user);

        $form_data = array_merge($jiri, [
            'contacts' => $contacts
        ]);

        $available_roles = [
            1 => ContactRoles::Evaluators->value,
            2 => ContactRoles::Evaluated->value,
        ];

        foreach ($contacts as $key => $contact) {
            $form_data['contacts'][$key] = ['role' => $available_roles[random_int(1, 2)]];
        }


        $response = $this->post(route('jiris.store'), $form_data);



        expect(Jiri::all()->count())->toBe(1);
        expect(Contact::all()->count())->toBe(2);
        expect(Attendance::all()->count())->toBe(2);
    });


it('creates a jiri with its contacts associated and its associated projects from a request containing jiri data, contacts ids including their roles and projects ids and creates all the relationships', function () {

    $contacts = Contact::factory()
        ->count(4)
        ->for(auth()->user())
        ->create()
        ->pluck('id', 'id')
        ->toArray();

    $projects = Project::factory()
        ->count(3)
        ->for(auth()->user())
        ->create()
        ->pluck('id', 'id')
        ->toArray();


    $jiri = Jiri::factory()->raw();


    $form_data = array_merge($jiri, [
        'contacts' => $contacts,
        'projects' => $projects,
    ]);


    $available_roles = [
        1 => ContactRoles::Evaluated->value,
        2 => ContactRoles::Evaluated->value
    ];

    foreach ($contacts as $key => $contact) {
        $form_data['contacts'][$key] = ['role' => $available_roles[random_int(1, 2)]];
    }


    $response = $this->post(route('jiris.store'), $form_data);

    $response->assertValid();

    expect(Jiri::all()->count())->toBe(1)
        ->and(Attendance::all()->count())->toBe(4)
        ->and(Homework::all()->count())->toBe(3)
        ->and(Implementation::all()->count())->toBe(12);

    $response->assertStatus(302);
});
