<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class RetreatantBirthday extends Mailable
{
    use Queueable, SerializesModels;

    public $retreatant;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($retreatant)
    {
        $this->retreatant = $retreatant;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $nameToUse = $this->retreatant->nick_name != null ? $this->retreatant->nick_name : $this->retreatant->first_name;

        if ($this->retreatant->preferred_language == 'es_ES') {
            return $this->replyTo('director@montserratretreat.org')
                        ->subject('Feliz Cumpleaños '.$nameToUse.'!')
                        ->view('emails.es_ES.birthday');
        } else { //en_US is the default language
            return $this->replyTo('director@montserratretreat.org')
                        ->subject('Happy Birthday '.$nameToUse.'!')
                        ->view('emails.en_US.birthday');
        }
    }
}
