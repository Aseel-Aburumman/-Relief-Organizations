<?php

namespace App\Mail;

use Illuminate\Mail\Mailable;

class NeedNotificationMail extends Mailable
{
    public $needDetails;

    /**
     * Create a new message instance.
     *
     * @param array $needDetails
     */
    public function __construct($needDetails)
    {
        $this->needDetails = $needDetails;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('A New Need Has Been Created')
                    ->view('emails.need_notification')
                    ->with([
                        'needDetails' => $this->needDetails,
                    ]);
    }
}
