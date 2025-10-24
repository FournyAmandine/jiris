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
use function Pest\Laravel\assertDatabaseMissing;


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
    $response = $this->post(route('jiris.index'), $jiri);

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
    \Pest\Laravel\actingAs($user);

    $jiris = Jiri::factory(4)
        ->for(auth()->user())
        ->create();


    $response = $this->get('/jiris');

    $response->assertStatus(200);
    $response->assertViewIs('jiris.index');
    $response->assertSee('Mes jiris');

    foreach ($jiris as $jiri) {
        $response->assertSee($jiri['name']);
    }
});

it('check if the jiri dashboard link corresponds to the correct jiri', function () {
    // Arrange
    $user = User::factory()->create();
    \Pest\Laravel\actingAs($user);

    $jiri = Jiri::factory()
        ->for(auth()->user())
        ->create();


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

    $response = $this->post(route('jiris.index'), $jiri);

    $response->assertInvalid('name');
    $response->assertInvalid('date');
});

it('creates a jiri with its projects associated from a request containing jiri data and project ids'
,function(){
    // Homeworks
        $user = User::factory()->create();
        \Pest\Laravel\actingAs($user);
        $jiri = Jiri::factory()->raw();
        $projects = Project::factory()
            ->count(2)
            ->for(auth()->user())
            ->create()
            ->pluck('id', 'id')
            ->toArray();



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
        \Pest\Laravel\actingAs($user);

        $jiri = Jiri::factory()->raw();
        $contacts = Contact::factory()
            ->count(2)
            ->for(auth()->user())
            ->create()
            ->pluck('id', 'id')
            ->toArray();


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

it('verifies if the user can modified his contact and if it is correctly saved in the database', function () {

    $jiri = Jiri::factory()
        ->for(auth()->user())
        ->create();

    $contact = Contact::factory()
        ->for(auth()->user())
        ->create();

    $project = Project::factory()
        ->for(auth()->user())
        ->create();

    $new_project = [
        'name' => 'CV',
    ];

    $response = $this->patch(route('jiris.update', $jiri->id));

    assertDatabaseMissing('projects', [

    ]);

    assertDatabaseHas('projects', [

    ]);


});

it('verifies if jiri data is correctly modified in the database when you edit the information about a jiri',
    function () {
        $user = User::factory()->create();
        \Pest\Laravel\actingAs($user);
        Event::fake('eloquent.created: App\Models\Jiri');

        // Créer en DB
        $available_roles = [
            1 => ContactRoles::Evaluated->value,
            2 => ContactRoles::Evaluated->value,
        ];

        $jiri = Jiri::factory()
            ->for($user)
            ->create();

        $contacts = Contact::factory()
            ->count(3)
            ->for($user)
            ->create()
            ->pluck('id', 'id')
            ->toArray();

        $projects = Project::factory()
            ->count(3)
            ->for($user)
            ->create()
            ->pluck('id', 'id')
            ->toArray();

        $jiri->contacts()->attach($contacts, ['role' => $available_roles[rand(1, 2)]]);
        $jiri->projects()->attach($projects);

        // Créer un array requête de base
        $data_in_database = array_merge($jiri->toArray(), [
            'projects' => $projects,
            'contacts' => $contacts,
        ]);

        foreach ($contacts as $key => $contact) {
            $data_in_database['contacts'][$key] = array('role' => $available_roles[rand(1, 2)]);
        }

        // Créer un array requête modifié
        $data_in_request = $data_in_database;

        $data_in_request['name'] = 'Amandine Fourny';
        $data_in_request['description'] = 'Hey description';

        $new_project = Project::factory()->for($user)->create();
        $data_in_request['projects'][$new_project->id] = $new_project->id;
        unset($data_in_request['projects'][1]);

        $new_contact = Contact::factory()->for($user)->create();
        $data_in_request['contacts'][$new_contact->id]['role'] = ContactRoles::Evaluated->value;
        $data_in_request['contacts'][1]['role'] = ContactRoles::Evaluators->value;
        $data_in_request['contacts'][2]['role'] = ContactRoles::Evaluated->value;
        unset($data_in_request['contacts'][3]);

        $response = $this->patch(route('jiris.update', $jiri['id']), $data_in_request);


        assertDatabaseHas('jiris',
            [
                'name' => $data_in_request['name'],
                'description' => $data_in_request['description'],
            ]);

        assertDatabaseMissing('jiris',
            [
                'name' => $data_in_database['name'],
                'description' => $data_in_database['description'],
            ]);

        assertDatabaseMissing('homeworks',
            [
                'jiri_id' => 1,
                'project_id' => 1
            ]);

        assertDatabaseHas('homeworks',
            [
                'jiri_id' => 1,
                'project_id' => 2
            ]);

        assertDatabaseHas('attendances',
            [
                'contact_id' => 1,
                'jiri_id' => 1,
                'role' => ContactRoles::Evaluators->value,
            ]);

        assertDatabaseMissing('attendances',
            [
                'contact_id' => 3,
                'jiri_id' => 1,
                'role' => ContactRoles::Evaluators->value,
            ]);
    }
);
