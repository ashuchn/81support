<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class githubActionMail extends Mailable
{
    use Queueable, SerializesModels;
    // public $details;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->details = $details;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.index')
            ->with([
                    // 'time' => date_create()->format('Y-m-d H:i:s'),
                    'time' => NOW(),
                ]);
    }
}
