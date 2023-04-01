<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class RegistrationCanceledChange extends Mailable
{
    use Queueable, SerializesModels;

    public $registration;

    public $retreat;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($registration, $retreat)
    {
        $this->registration = $registration;
        $this->retreat = $retreat;
    }

    /**
     * Build the message.
     */
    public function build(): static
    {   //TODO: consider looking up the preferred language of the contact with the finance email address and send message in preferred language - English is OK for now
        return $this->subject('Notification of Registration Update: Canceled (with deposit)')
                    ->replyTo('registration@montserratretreat.org')
                    ->view('emails.en_US.registration-canceled-change');
    }
}
