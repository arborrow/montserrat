<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class RetreatConfirmation extends Mailable
{
    use Queueable, SerializesModels;

    public $participant;

    public $encodedUrl;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($participant)
    {
        $this->participant = $participant;
        $this->encodedUrl = base64_encode("registration/confirm/$participant->remember_token");
    }

    /**
     * Build the message.
     */
    public function build(): static
    {
        if ($this->participant->contact->preferred_language == 'es_ES') {
            return $this->subject('Preparando para su retiro #'
                        .$this->participant->retreat->idnumber.' starting on '
                        .$this->participant->retreat_start_date->format('l F jS'))
                ->replyTo('registration@montserratretreat.org')
                ->view('emails.es_ES.event-confirmation');
        } else { //en_US is the default locale/language
            return $this->subject('Preparing for your Upcoming Retreat #'
                        .$this->participant->retreat->idnumber.' starting on '
                        .$this->participant->retreat_start_date->format('l F jS'))
                ->replyTo('registration@montserratretreat.org')
                ->view('emails.en_US.event-confirmation');
        }
    }
}
