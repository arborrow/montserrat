<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class RetreatRegistration extends Mailable
{
    use Queueable, SerializesModels;

    public $participant;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($participant)
    {
        $this->participant = $participant;
    }

    /**
     * Build the message.
     */
    public function build(): static
    {
        return $this->subject('Registration email')
                    ->replyTo('registration@montserratretreat.org')
                    ->view('emails.retreat-registration');
    }
}
