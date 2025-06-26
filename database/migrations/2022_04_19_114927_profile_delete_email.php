<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class ProfileDeleteEmail extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement("INSERT INTO `email_templates` (`id`, `template_name`, `subject`, `body`, `variables`, `created_at`, `updated_at`) VALUES (
NULL,
  'Candidate Delete Verified','Profil törlés megerősítése',
    '<p align=\"left\">Tisztelt {{first_name}} {{last_name}}!</p><p align=\"left\">
Rendszerünk szerint Ön a munkavállalói profiljának törlését kezdeményezte. Amennyiben a törlést szeretné véglegesíteni kattintson az alábbi linkre.<br>
<p align=\"left\"><a href=\"{{delete_profile_url}}\" target=\"_blank\">Profil törlése</a><br><br>
<br>MUMI.HU csapata<br>www.mumi.hu<br></p>','{{first_name}},{{last_name}},{{user_id}},{{delete_profile_url}}', NULL, '2022-04-10 11:58:00');");

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
