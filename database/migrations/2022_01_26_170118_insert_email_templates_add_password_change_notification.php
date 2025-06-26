<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class InsertEmailTemplatesAddPasswordChangeNotification extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement("INSERT INTO `email_templates` (`id`, `template_name`, `subject`, `body`, `variables`, `created_at`, `updated_at`) VALUES (NULL, 'Password Updated', 'Jelszó megváltoztatva', '<div style=\"text-align: left;\" class=\"text-blue-color\">\n                                <strong>Hello!,</strong>\n                            </div>\n                            <br/>\n                            You are receiving this email because we received a password reset request for your account.\n                            <br/><br>\n                            <div style=\"display: flex; justify-content: center;width: 100%;\">\n                                <a href=\"{{reset_url}}\">Reset Password</a>\n                            </div>\n                            <br><br>\n                            This password reset link will expire in 60 minutes.<br><br>\n                            If you did not request a password reset, no further action is required.<br><br>\n                            <strong style=\"display: block; margin-top: 15px;\" class=\"text-blue-color\">Regards, <br/>\n                                {{from_name}}\n                            </strong>\n                            ', '{{first_name}}', '2022-01-26 17:46:16', '2022-01-26 17:46:18');");

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
