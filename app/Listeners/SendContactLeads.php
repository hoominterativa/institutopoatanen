<?php

namespace App\Listeners;

use App\Events\SendEmail;
use App\Mail\ContactLead;
use Illuminate\Support\Facades\Mail;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendContactLeads implements ShouldQueue
{
    public $delay = 20;

    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  \App\Events\SendEmail  $event
     * @return void
     */
    public function handle(SendEmail $event)
    {
        Mail::send(new ContactLead($event->informations, $event->emailRecipient));
    }
}
