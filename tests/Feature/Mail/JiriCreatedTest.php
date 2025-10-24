<?php

use App\Events\JiriCreatedEvent;
use App\Listeners\SendJiriCreatedEmailListener;
use App\Mail\JiriCreatedMail;
use App\Models\Jiri;
use App\Models\User;
use function Pest\Laravel\actingAs;
use function Pest\Laravel\post;
use \Illuminate\Support\Facades\{Event, Mail};

it('fires an event asking to queue an email to send to the author after the creation of a jiri', function (){
    Event::fake();
    $user = User::factory()->create();
    actingAs($user);

    $formData = Jiri::factory()->raw();

    post(route('jiris.store'), $formData);


    Event::assertListening(
        JiriCreatedEvent::class,
        SendJiriCreatedEmailListener::class
    );
    Event::assertDispatched(JiriCreatedEvent::class);
});

it('fills correctly the email with the values from the jiri', function () {

    $jiri = Jiri::factory()
        ->for(User::factory())
        ->create();

    $mail = new JiriCreatedMail($jiri);

    $mail->assertSeeInHtml($jiri->name);
});

it('sends the email using the configured transport layer', function () {
//C'est pour faire rater le test si mailpit n'est pas lancer
    Event::fake(['eloquent.created: App\Models\Jiri']);
    $user = User::factory()->create();

    $jiri = Jiri::factory()
        ->for($user)
        ->create();
    try {
        Mail::to($user->email)->send(new JiriCreatedMail($jiri));
    } catch (Exception $e){
        test()->fail($e->getMessage());
    }
    $response = file_get_contents('http://localhost:8025/api/v1/messages');

    $messages = json_decode($response, true);

    $this->assertNotEmpty($messages['messages']);
});

it('queues the sending of the jiri created email after the jiri created event has been fired', function () {
    Mail::fake();
    $jiri = Jiri::factory()
        ->for(User::factory())
        ->create();
    \event(new JiriCreatedEvent($jiri));
    Mail::assertQueued(App\Mail\JiriCreatedMail::class);
});
