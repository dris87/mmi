<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class InsertCompanyNotifications extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement("delete from email_templates where template_name = 'Verify Email'");
        DB::statement("INSERT INTO `email_templates` (`id`, `template_name`, `subject`, `body`, `variables`, `created_at`, `updated_at`) VALUES (NULL, 'Verify Email', 'Regisztráció megerősítése', '
<p>Tisztelt {{first_name}},<br><br>
Regisztrációja sikeres volt. Kérjük, kattintson az alábbi linkre, hogy megerősítse és aktiválja munkavállalói profilját.
<br><br><a href=\"{{verification_url}}\" target=\"_blank\">Fiók megerősítése</a></p>
<p>Üdvözlettel,<br>
MUMI.HU csapata<br>
www.mumi.hu<br><br></p>
', '{{first_name}},{{last_name}},{{verification_url}},{{user_email}}', '2022-01-21 16:59:48', '2022-01-21 16:06:47')");

        DB::statement("INSERT INTO `email_templates` (`id`, `template_name`, `subject`, `body`, `variables`, `created_at`, `updated_at`) VALUES (NULL, 'Email Verified', 'Munkavállalói fiók véglegesítése', '
<p>Tisztelt {{first_name}},<br>
<br>Regisztrációjának megerősízése sikeres volt.<br>
Az alábbi adatok segítségével bejelentkezhet a profiljába:
<br>
<br>
<a href=\"{{login_url}}\" target=\"_blank\">Bejelentkezés</a>
<br>
<br>Felhasználó név: {{user_email}}
<br>Jelszó: A regisztrációkor megadott jelszó<br>
</p><p>Üdvözlettel,<br>MUMI.HU csapata<br>www.mumi.hu<br></p>'
, '{{first_name}},{{last_name}},{{user_email}},{{login_url}}', '2022-01-21 16:59:48', '2022-01-21 16:09:36');");
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
