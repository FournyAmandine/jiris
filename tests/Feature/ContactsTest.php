<?php

use App\Models\Contact;

use function Pest\Laravel\assertDatabaseHas;

it('creates a contact and redirects to the contact index', function () {

    $contact = ['name' => 'Victoria Briol',
        'email' => 'victoriabriel@gmail.com'];

    $response = $this->post('/contacts', $contact);

    $response->assertStatus(302);
    $response->assertRedirect('/contacts');
    assertDatabaseHas('contacts', ['name' => 'Victoria Briol']);
});

it('display a complete list of contacts on the contact index page', function () {
    $contacts = Contact::factory(4)->create();

    $response = $this->get('/contacts');

    $response->assertStatus(200);
    $response->assertViewIs('contacts.index');
    $response->assertSee('Liste des contacts');

    foreach ($contacts as $contact) {
        $response->assertSee($contact['name'], ['email']);
    }
});

it('check if the contact dashboard link corresponds to the correct contact', function () {
    $contact = Contact::factory()->create();

    $response = $this->get('contacts/'.$contact->id);

    $response->assertStatus(200);
    $response->assertViewIs('contacts.show');
    $response->assertSee('Récapitulatif du contact : '.$contact->name);

});

it('validate informations about a new contact', function () {
    $contact = ['name' => '', 'email' => ''];

    $response = $this->post('/contacts', $contact);

    $response->assertInvalid('name');
    $response->assertInvalid('email');
});
