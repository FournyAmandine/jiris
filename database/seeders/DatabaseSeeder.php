<?php

namespace Database\Seeders;

use App\Models\Contact;
use App\Models\Jiri;
use App\Models\Project;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        User::factory()->create([
            'name' => 'Amandine Fourny',
            'email' => 'amandine.fourny@gmail.com',
            'password' => password_hash('amandine', PASSWORD_BCRYPT),
        ]);

        Jiri::factory()->create([
            'name' => 'Design Web',
            'date' => Carbon::now(),
            'description' => 'Jury de juin de Design Web',
            'user_id' => rand(1, count(User::all())),
        ]);

        Jiri::factory()->create([
            'name' => 'Design web 2',
            'date' => Carbon::now(),
            'description' => 'Jury de septembre de Design Web',
            'user_id' => rand(1, count(User::all())),
        ]);

        Jiri::factory()->count(5)->create(
            [
                'user_id' => rand(1, count(User::all()))
            ]
        );

        Contact::factory()->count(5)->create(
            [
                'user_id' => rand(1, count(User::all()))
            ]
        );

        Project::factory()->create([
            'name' => 'CV',
            'user_id' => rand(1, count(User::all()))

        ]);

        Project::factory()->create([
            'name' => 'Projet Client',
            'user_id' => rand(1, count(User::all()))
        ]);

        Project::factory()->create([
            'name' => 'Portfolio',
            'user_id' => rand(1, count(User::all()))
        ]);

        Project::factory()->count(5)->create(
            [
                'user_id' => rand(1, count(User::all()))
            ]
        );
    }
}
