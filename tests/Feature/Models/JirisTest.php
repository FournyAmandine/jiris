<?php

use App\Enums\ContactRoles;
use App\Models\Contact;
use App\Models\Jiri;
use App\Models\Project;
use App\Models\User;
use function Pest\Laravel\actingAs;

it(
    'is possible to retrieve many evaluated/evaluators from a Jiri',
    function (){
        $user = User::factory()->create();

        $contact1 = Contact::factory()->for($user)->count(7)->create();
        $contact2 = Contact::factory()->for($user)->count(3);

        actingAs($user);

        $jiri = Jiri::factory()
            ->hasAttached(
                $contact1,
                ['role' => ContactRoles::Evaluated->value]
            )

            ->hasAttached(
                $contact2,
                ['role' => ContactRoles::Evaluators->value]
            )
            ->for($user)
            ->create();


            $this->assertDatabaseCount('attendances', 10);
            expect($jiri->evaluators->count())->toBe(3)
                ->and($jiri->evaluated->count())->toBe(7)
                ->and($jiri->contacts->count())->toBe(10)
                ->and($jiri->attendances->count())->toBe(10);
    }
);

it('is possible to retrieve many projects from a Jiri',
    function () {
        $user = User::factory()->create();
        actingAs($user);

        $project = Project::factory()->for($user)->count(4);


        $jiri = Jiri::factory()

            ->hasAttached(
                $project
            )
            ->for(auth()->user())
            ->create();



            $this->assertDatabaseCount('homeworks', 4);
            expect($jiri->projects->count())->toBe(4);
    }
);

it('is possible to retrieve many implementations from an evaluated attending a Jiri',
    function () {
        $user = User::factory()
            ->create();
        actingAs($user);

        $contact = Contact::factory()->for($user)->count(1);
        $project = Project::factory()->for($user)->count(3);

        $jiri = Jiri::factory()
            ->hasAttached(
                $contact,
                ['role' => ContactRoles::Evaluated->value]
            )
            ->hasAttached(
                $project
            )
            ->for($user)
            ->create();


        $contact = $jiri->evaluated->first();
        $homeworks = $jiri->homeworks;
        foreach($homeworks as $homework){
            $contact->homeworks()->attach($homework);
        }

            $this->assertDatabaseCount('implementations', 3);
            expect($jiri->homeworks->count())->toBe(3)
            ->and($contact->homeworks->count())->toBe(3)
            ->and($contact->implementations->count())->toBe(3);

            foreach ($homeworks as $homework){
                expect($homework->implementations->count())->toBe(1);
            }

    }
);
