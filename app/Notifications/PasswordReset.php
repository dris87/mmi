<?php

namespace App\Notifications;

use App\Helpers\Mailer;
use App\Models\EmailTemplate;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class PasswordReset extends Notification
{
    use Queueable;

    /**
     * The password reset token.
     *
     * @var string
     */
    public $token;
    public $user;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($token, User $user)
    {
        $this->token = $token;
        $this->user = $user;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array
     */
    public function via(): array
    {
        return ['mail'];
    }

    /**
     * Build the mail representation of the notification.
     *
     */
    public function toMail()
    {
        $arrData = [
            "first_name" => $this->user->first_name,
            "reset_url" => url('password/reset', $this->token),
            "from_name" =>  config('app.name'),
        ];
        Mailer::send($this->user, EmailTemplate::Password_Reset, $arrData);
    }
}
