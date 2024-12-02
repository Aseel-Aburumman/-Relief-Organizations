<?php

namespace App\Mail;

use Illuminate\Mail\Mailable;

class PasswordResetMail extends Mailable
{
    public $resetLink;

    /**
     * Create a new message instance.
     *
     * @param string $resetLink
     */
    public function __construct($resetLink)
    {
        $this->resetLink = $resetLink;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Reset Your Password')
                    ->view('emails.password_reset')
                    ->with([
                        'resetLink' => $this->resetLink,
                    ]);
    }
}
