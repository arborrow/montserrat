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

        return $this->replyTo('director@montserratretreat.org')
                    ->subject('Happy Birthday '.$nameToUse.'!')
                    ->view('emails.retreatant-birthday');
    }
}
