<?php

namespace App\Mail;

use Illuminate\Mail\Mailable;

class ForgotPassword extends Mailable
{
    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('forgetpasswordemail');
    }
}