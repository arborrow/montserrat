<?php

namespace App\Mail;

use App\Models\Registration;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PostRetreat extends Mailable
{
    use Queueable, SerializesModels;

    public $participant;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Registration $participant)
    {
        $this->participant = $participant;
    }

    /**
     * Build the message.
     */
    public function build(): static
    {

        if ($this->participant->preferred_language == 'es_ES') {
            return $this->replyTo('registration@montserratretreat.org')
                ->subject('Foto del grupo despues del retiro para '.$this->participant->contact->display_name)
                ->view('emails.es_ES.post-retreat');
        } else { //en_US is the default language
            return $this->replyTo('registration@montserratretreat.org')
                ->subject('Post Retreat Group Picture '.$this->participant->contact->display_name)
                ->view('emails.en_US.post-retreat');
        }
    }
}
