<?php

use App\Models\Jiri;
use App\Models\User;
use function Pest\Laravel\actingAs;

it('can display the login form', function (){
    //action
    $response = $this->get('/login');

    //assert
    $response->assertSee('Connexion à l’espace Jury');
    $response->assertSeeInOrder(['<form', 'Entrez votre email', 'Entrez votre mot de passe', '<button', 'Se connecter'], true);
});

it('we are redirected to the dashboard after a successful request', function () {

    $password = 'amandine';
    $user = User::factory()->create([
        'name'=>'Amandine Fourny',
        'email' => 'amandine.fourny@gmail.com',
        'password' => \Illuminate\Support\Facades\Hash::make($password)
    ]);

    $response = $this->post(route('login.store'),
        [
            'email'=>$user->email,
            'password'=>$password,
        ]);

    $response->assertStatus(302);
    $response->assertRedirect(route('jiris.index'));

});

it('a guest can’t access to the jiris.index and if he redirect to the login page', function () {

    //action
    $response = $this->get(route('jiris.index'));

    //assert
    $response->assertStatus(302);
    $response->assertRedirect(route('login'));
});

it('the jiris on the dashboard are associated to the current user', function () {
    $user = User::factory()
        ->has(Jiri::factory()->count(3))
        ->create();

    $second_user = User::factory()
        ->has(Jiri::factory()->count(4))
        ->create();

    actingAs($user);

    $response= $this->get(route('jiris.index'));

    foreach ($user->jiris as $jiri){
        $response->assertSee($jiri->name);
    }

    foreach ($second_user->jiris as $jiri){
        $response->assertDontSee($jiri->name);
    }
});

it('the user is successfully taken to the jiris.edit view', function () {
    $user = User::factory()->create();
    actingAs($user);


    $jiri = Jiri::factory()->for(auth()->user())->create();


    $response = $this->get(route('jiris.edit', $jiri->id));

    $response->assertStatus(200);
    $response->assertViewIs('jiris.edit');
    $response->assertSee('Modifiez votre jiri');
});

it(' a guest can’t access to the contacts.index and if he redirect to the login page', function () {

    //action
    $response = $this->get(route('contacts.index'));

    //assert
    $response->assertStatus(302);
    $response->assertRedirect(route('login'));
});
