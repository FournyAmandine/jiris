<?php

use App\Models\Contact;

use App\Models\User;
use function Pest\Laravel\actingAs;
use function Pest\Laravel\assertDatabaseHas;

it('creates a contact and redirects to the contact show', function () {

    $user = User::factory()->create();

    \Pest\Laravel\actingAs($user);

    \Illuminate\Support\Facades\Storage::fake('public');

    $avatar = \Illuminate\Http\UploadedFile::fake()->image('photo.jpg');

    $contact = [
        'name' => 'Victoria Briol',
        'email' => 'victoriabriel@gmail.com',
        'avatar' => $avatar,
    ];

    $response = $this->post(route('contacts.store'), $contact);

    $contact = Contact::first();
    \Illuminate\Support\Facades\Storage::disk('public')->assertExists($contact->avatar);
    $response->assertStatus(302);
    $response->assertRedirect(route('contacts.show', compact('contact')));
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

it('validate information about a new contact', function () {
    $contact = ['name' => '', 'email' => ''];

    $response = $this->post('/contacts', $contact);

    $response->assertInvalid('name');
    $response->assertInvalid('email');
});



it('the user is successfully taken to the contacts.show view', function () {
    $user = User::factory()->create();
    actingAs($user);

    $contact = Contact::factory()->for(auth()->user())->create();


    $response = $this->get(route('contacts.show', $contact->id));

    $response->assertStatus(200);
    $response->assertViewIs('contacts.show');
    $response->assertSee($contact->name);
});


it('the contacts.edit view exists', function () {
    $user = User::factory()->create();
    actingAs($user);

    $contact = Contact::factory()->for(auth()->user())->create();


    $response = $this->get(route('contacts.edit', $contact->id));

    $response->assertStatus(200);
    $response->assertViewIs('contacts.edit');
    $response->assertSee('Modifiez votre contact');
});
