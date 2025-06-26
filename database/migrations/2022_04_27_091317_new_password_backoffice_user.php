<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class NewPasswordBackofficeUser extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement("
        INSERT INTO
                `email_templates` (`id`, `template_name`, `subject`, `body`, `variables`, `created_at`, `updated_at`) VALUES (
        NULL,
        'Backoffice user new password','Új munkatárs profil jelszó',
        '<p align=\"left\">Tisztelt {{first_name}} {{last_name}}!</p><p align=\"left\">
Az Ön email címével Mumi rendszer hozzáférés lett készítve. Fiókja jelenleg nem megerősített.<br>
Az alábbi link segítéségével új jelszót rendelhetet fiókjához és aktiválhatja azt.<br>
<p align=\"left\"><a href=\"{{reset_url}}\" target=\"_blank\">Új jelszó megadása</a><br><br>
<br>MUMI.HU csapata<br>www.mumi.hu<br></p>',
        '{{first_name}},{{last_name}},{{reset_url}}', NULL, '2022-04-10 11:58:00');");


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
