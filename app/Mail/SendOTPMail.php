<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SendOTPMail extends Mailable
{
    use Queueable, SerializesModels;

     protected $otp_number;

    public function __construct($number)
    {
    $this->otp_number =$number;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('email.sendOtp')
            ->subject('Get Otp Commission Income')
            ->with('otp_number',$this->otp_number);
    }
}
