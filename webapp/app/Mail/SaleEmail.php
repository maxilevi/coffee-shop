<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class SaleEmail extends Mailable
{
    use Queueable, SerializesModels;

    private $shippingUrl;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($shippingUrl)
    {
        $this->shippingUrl = $shippingUrl;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('email.sale')
                    ->from('soporte@outletdecafe.com', 'Juan de OUTLET DE CAFÉ')
                    ->replyTo('soporte@outletdecafe.com', 'Juan de OUTLET DE CAFÉ')
                    ->subject('Tu compra en OUTLET DE CAFÉ')
                    ->bcc('maxilevi77@gmail.com')
                    ->with(['shippingUrl' => $this->shippingUrl]);
    }
}
