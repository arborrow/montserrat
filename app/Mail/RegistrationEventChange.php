<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class RegistrationEventChange extends Mailable
{
    use Queueable, SerializesModels;

    public $registration;

    public $retreat;

    public $original_event;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($registration, $retreat, $original_event)
    {
        $this->registration = $registration;
        $this->retreat = $retreat;
        $this->original_event = $original_event;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {   //TODO: consider looking up the preferred language of the contact with the finance email address and send message in preferred language - English is OK for now
        return $this->subject('Notification of Registration Update: Event changed')
                    ->replyTo('registration@montserratretreat.org')
                    ->view('emails.en_US.registration-event-change');
    }
}
