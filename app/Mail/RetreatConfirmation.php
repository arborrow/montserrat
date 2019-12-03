<?php

namespace App\Mail;

use App\Registration;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
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
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Preparing for your Upcoming Retreat #'
                    .$this->participant->retreat->idnumber.' starting on '
                    .$this->participant->retreat_start_date->format('l F jS'))
                    ->replyTo('registration@montserratretreat.org')
                    ->view('emails.retreat-confirmation');
    }
}
