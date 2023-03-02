<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class sendOtp extends Mailable
{
    use Queueable, SerializesModels;
    public $otp;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($otp)
    {
        $this->otp = $otp;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        //  return $this->from('dinocajic@gmail.com')
        //             ->subject('Pure Randomness')
        //             ->view('mail.sendOtp');

        return $this->view('emails.otp')
        ->subject('Forgot Password')
        ->with([
            'otp' => $this->otp
        ]);

    }
}
