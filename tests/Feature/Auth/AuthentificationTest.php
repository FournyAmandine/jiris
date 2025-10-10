<?php

use App\Models\Jiri;
use App\Models\User;

it('can display the login form', function (){
    //action
    $response = $this->get('/login');

    //assert
    $response->assertSee('Connexion à l’espace Jury');
    $response->assertSeeInOrder(['<form', 'Entrez votre email', 'Entrez votre mot de passe', '<button', 'Se connecter'], true);
});

it('verifies if we are redirected to the dashboard after a successful request', function () {

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

it('verifies if a guest can’t access to the jiris.index and if he redirect to the login page', function () {

    //action
    $response = $this->get(route('jiris.index'));

    //assert
    $response->assertStatus(302);
    $response->assertRedirect(route('login'));
});

it('verifies if the jiris on the dashboard are associated to the current user', function () {
    $user = User::factory()->create();

});
