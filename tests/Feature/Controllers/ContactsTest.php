<?php

use App\Models\Contact;

use App\Models\User;
use function Pest\Laravel\actingAs;
use function Pest\Laravel\assertDatabaseHas;
use \Illuminate\Support\Facades\Storage;
use  \Intervention\Image\Laravel\Facades\Image;
use function Pest\Laravel\assertDatabaseMissing;

it('creates a contact and redirects to the contact show', function () {

    $user = User::factory()->create();

    \Pest\Laravel\actingAs($user);

    Storage::fake('public');

    $avatar = \Illuminate\Http\UploadedFile::fake()->image('photo.jpg');

    $contact = [
        'name' => 'Victoria Briol',
        'email' => 'victoriabriel@gmail.com',
        'avatar' => $avatar,
    ];

    $response = $this->post(route('contacts.store'), $contact);

    $contact = Contact::first();
    Storage::disk('public')->assertExists($contact->avatar);
    $response->assertStatus(302);

    $image = Image::read(Storage::disk('public')->get($contact->avatar));

    expect($image->width())
        ->toBeLessThanOrEqual(300)
        ->and($image->height())
        ->toBeLessThanOrEqual(300);

    $response->assertRedirect(route('contacts.show', compact('contact')));
    assertDatabaseHas('contacts', ['name' => 'Victoria Briol']);
});

it('display a complete list of contacts on the contact index page', function () {
    $user = User::factory()->create();
    actingAs($user);

    $contacts = Contact::factory(4)
        ->for(auth()->user())
        ->create();

    $response = $this->get('/contacts');

    $response->assertStatus(200);
    $response->assertViewIs('contacts.index');
    $response->assertSee('Mes contacts');

    foreach ($contacts as $contact) {
        $response->assertSee($contact['name'], ['email']);
    }
});

it('check if the contact dashboard link corresponds to the correct contact', function () {
    $user = User::factory()->create();
    actingAs($user);

    $contact = Contact::factory()
        ->for(auth()->user())
        ->create();

    $response = $this->get('contacts/'.$contact->id);

    $response->assertStatus(200);
    $response->assertViewIs('contacts.show');
    $response->assertSee($contact->name);

});

it('validate information about a new contact', function () {
    $user = User::factory()->create();
    actingAs($user);

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

it('verifies if the user can’t modifies an other contact', function () {
    $user = User::factory()->create();
    actingAs($user);

    $contact = Contact::factory()->for($user)->create();

    $response = $this->patch(route('contacts.update', $contact));

    $response->assertStatus(403);

});


it('verifies if the user can modified his contact and if it is correctly saved in the database', function () {
    $user = User::factory()->create();
    actingAs($user);

    $contact = Contact::factory()->for(auth()->user())->create();

    $new_contact = [
        'name' => 'Victoria',
        'email' => 'vi.be@gmail.com',
    ];

    $response = $this->patch(route('contacts.update', $contact->id), $new_contact);

    assertDatabaseMissing('contacts', [
        'name' =>$contact->name,
        'email' => $contact->email,
    ]);

    assertDatabaseHas('contacts', [
        'name' =>$new_contact['name'],
        'email' => $new_contact['email'],
    ]);


});
