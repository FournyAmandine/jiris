<?php

it('can display the register form', function (){
    //action
    $response = $this->get('/register');

    //assert
    $response->assertSee('Création d’un espace Jury');
    $response->assertSeeInOrder(['<form', 'Entrez votre nom', 'Entrez votre email', 'Entrez un mot de passe', '<button', 'Créez l’espace'], true);
});
