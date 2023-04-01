<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class WebError extends Mailable
{
    use Queueable, SerializesModels;

    public $web_error;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($web_error)
    {
        $this->web_error = $web_error;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build(): static
    {
        $web_error = $this->web_error['body'];

        return $this->from(config('polanco.site_email'))
                ->subject($this->web_error['subject'])
                ->view('emails.en_US.error');
    }
}
