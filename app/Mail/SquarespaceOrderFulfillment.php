<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SquarespaceOrderFulfillment extends Mailable
{
    use Queueable, SerializesModels;

    public $order;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($order)
    {
        $this->order = $order;
    }

    /**
     * Build the message.
     */
    public function build(): static
    {
        if ($this->order->retreatant->preferred_language == 'es_ES') {
            $subject = \App\Models\Snippet::whereTitle('squarespace_order_fulfillment')->whereLocale('es_ES')->whereLabel('subject')->firstOrFail();

            return $this->replyTo('registration@montserratretreat.org')
                ->subject($subject->snippet)
                ->view('emails.es_ES.squarespace_order_fulfillment');
        } else { //en_US is the default language
            $subject = \App\Models\Snippet::whereTitle('squarespace_order_fulfillment')->whereLocale('en_US')->whereLabel('subject')->firstOrFail();

            return $this->replyTo('registration@montserratretreat.org')
                ->subject($subject->snippet)
                ->view('emails.en_US.squarespace_order_fulfillment');
        }
    }
}
