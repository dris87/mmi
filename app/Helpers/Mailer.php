<?php

namespace App\Helpers;

use App\Mail\EmailToCandidate;
use App\Mail\EmailToEmployer;
use App\Mail\GeneralMail;
use App\Models\EmailTemplate;
use App\Models\User;
use App\Repositories\EmailTemplateRepository;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Support\Facades\Mail;

class Mailer
{
    public static function send(User $objUser, $template_name, $arrData)
    {
        $mailContent = Mailer::setupMailContent($objUser, $template_name, $arrData);
        $data = [];
        $data['body'] = $mailContent['body'];

        Mail::to($objUser->email)->send(new GeneralMail($data, $mailContent['subject']));
    }

    public static function setupMailContent(User $objUser, $template_name, $arrData){
        /** @var EmailTemplate $templateBody */
        $objTemplate = EmailTemplate::whereTemplateName($template_name)->first();

        if(!$objTemplate){
            return false;
        }

        $subject = $objTemplate->subject;
        $body = $objTemplate->body;
        foreach ($arrData as $shortCode => $content) {

            $body = str_replace("{{" . $shortCode . "}}", $content, $body);
            $subject = str_replace("{{" . $shortCode . "}}", $content, $subject);
        }

        $body = str_replace("{{from_name}}",  config('app.name'), $body);
        $subject = str_replace("{{from_name}}",  config('app.name'), $subject);

        return[
            'subject' => $subject,
            'body'  => $body,
        ];
    }


}
