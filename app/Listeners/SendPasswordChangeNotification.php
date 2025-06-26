<?php

namespace App\Listeners;

use App\Helpers\Mailer;
use App\Models\EmailTemplate;
use App\Models\Factories\UserFactory;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendPasswordChangeNotification
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param PasswordReset $event
     * @return void
     */
    public function handle(PasswordReset $event)
    {
        $user = $event->user;
        $objUser = (new UserFactory())->getById($user->id);

        $arrData = [
            "first_name"=>$objUser->first_name,
            "app_url"=> config('app.url'),
        ];

        Mailer::send($objUser,EmailTemplate::Password_Updated, $arrData);
    }
}
