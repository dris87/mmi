<?php

namespace App\Notifications;

use App\Helpers\Mailer;
use App\Models\EmailTemplate;
use Auth;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class UserVerifyNotification extends VerifyEmail implements ShouldQueue
{
    use Queueable;

    public $user;            //you'll need this to address the user

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($user = '')
    {
        $this->user = $user ?: Auth::user();         //if user is not supplied, get from session
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param mixed $notifiable
     * @return mixed
     */
    public function toMail($notifiable)
    {
        $url = $this->verificationUrl($notifiable);     //verificationUrl required for the verification link
        $user = $this->user;
        if ($user->getCompany()) {

            $arrData = [
                "first_name" => $user->first_name,
                "last_name" => $user->last_name,
                "user_email" => $user->email,
                "company_name" => $user->company()->first()->name,
                "verification_url" => $url,
            ];
            Mailer::send($user, EmailTemplate::Company_Verification, $arrData);

        } else {

            $arrData = [
                "first_name" => $user->first_name,
                "last_name" => $user->last_name,
                "user_email" => $user->email,
                "verification_url" => $url,
            ];
            Mailer::send($user, EmailTemplate::Candidate_Verification, $arrData);

        }
    }

    /**
     * Get the array representation of the notification.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
