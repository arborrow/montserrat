<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

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
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Preparing for your Upcoming Retreat #'
                    .$this->participant->retreat->idnumber.' starting on '
                    .$this->participant->retreat_start_date->format('l F nS'))
                    ->replyTo('registration@montserratretreat.org')
                    ->view('emails.retreat-registration');
    }
}
