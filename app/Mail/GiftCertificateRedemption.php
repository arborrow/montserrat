<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class GiftCertificateRedemption extends Mailable
{
    use Queueable, SerializesModels;

    public $gift_certificate;

    public $order;

    public $reallocation_payment;

    public $negative_reallocation_payment;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($gift_certificate, $order, $negative_reallocation_payment, $reallocation_payment)
    {
        $this->gift_certificate = $gift_certificate;
        $this->order = $order;
        $this->negative_reallocation_payment = $negative_reallocation_payment;
        $this->reallocation_payment = $reallocation_payment;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build(): static
    {   //TODO: consider looking up the preferred language of the contact with the finance email address and send message in preferred language - English is OK for now
        return $this->subject('Redemption Notification for Gift Certificate #'.$this->gift_certificate->certificate_number)
                    ->replyTo('registration@montserratretreat.org')
                    ->view('emails.en_US.gift-certificate-redepmtion');
    }
}
