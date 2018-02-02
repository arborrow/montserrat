<?php

namespace montserrat\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class RetreatantBirthday extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->replyTo('director@montserratretreat.org')
                    ->subject('Monserrat Jesuit Retreat House wishes you a Happy Birthday!')
                    ->view('emails.retreatant-birthday');
    }
}
