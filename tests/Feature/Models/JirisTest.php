<?php

use App\Enums\ContactRoles;
use App\Models\Contact;
use App\Models\Jiri;
use App\Models\Project;

it('is possible to retrieve many evaluated/evaluators from a Jiri',
    function (){
        $jiri = Jiri::factory()

            ->hasAttached(
                Contact::factory()->count(7),
                ['role' => ContactRoles::Evaluated->value]
            )

            ->hasAttached(
                Contact::factory()->count(3),
                ['role' => ContactRoles::Evaluators->value]
            )
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
        $jiri = Jiri::factory()
            ->hasAttached(
                Project::factory()->count(4),
            )
            ->create();

            $this->assertDatabaseCount('homeworks', 4);
            expect($jiri->projects->count())->toBe(4);
    }
);

it('is possible to retrieve many implementations from an evaluated attending a Jiri',
    function () {
        $jiri = Jiri::factory()
            ->hasAttached(
                Contact::factory()->count(1),
                ['role' => ContactRoles::Evaluated->value]
            )
            ->hasAttached(
                Project::factory()->count(3)
            )
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
