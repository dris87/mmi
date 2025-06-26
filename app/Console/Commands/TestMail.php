<?php

namespace App\Console\Commands;

use App\Helpers\Mailer;
use App\Models\EmailTemplate;
use App\Repositories\UserRepository;
use Illuminate\Console\Command;

class TestMail extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test:mail';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Test Email';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $objUser = (new UserRepository())->getById(7);

        $arrData = [
            "first_name"=>$objUser->first_name,
            "last_name"=>$objUser->last_name,
            "company_name"=>"test compnay"
        ];

        var_dump($objUser->first_name);
        var_dump($arrData);

        Mailer::send($objUser,EmailTemplate::Account_Verification, $arrData);

    }
}
