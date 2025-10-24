<?php

namespace App\Listeners;

use App\Events\JiriCreatedEvent;
use App\Mail\JiriCreatedMail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class SendJiriCreatedEmailListener
{
    public function __construct()
    {
    }

    public function handle(JiriCreatedEvent $event): void
    {
        Mail::to(request()->user())->queue(new JiriCreatedMail($event->jiri));
    }
}
