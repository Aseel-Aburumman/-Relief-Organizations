<?php

namespace App\Notifications;

use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Notifications\Messages\MailMessage;
use App\Mail\PasswordResetMail;

class ResetPasswordNotification extends ResetPassword
{
    /**
     * Build the mail representation of the notification.
     *
     * @param string $token
     * @return \Illuminate\Mail\Mailable
     */
    public function toMail($notifiable)
    {
        $resetLink = url(route('password.reset', [
            'token' => $this->token,
            'email' => $notifiable->getEmailForPasswordReset(),
        ], false));

        return (new PasswordResetMail($resetLink))->to($notifiable->email);
    }
}
