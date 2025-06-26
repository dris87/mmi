<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class SendCompnayEmail extends Migration
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
  'Job Company Review','Álláshirdetés felülvizsálatra vár',
    '<p align=\"left\">Tisztelt {{first_name}}!</p><p align=\"left\">
Az alábbi hirdetés felülvizsgálatra vár:<br>
Pozicíó megnevezése: {{position}}<br>
Cég neve: {{company_name}}</p><br>A hirdetést az alábbi linken megtekintheti.<p align=\"left\"><a href=\"{{job_url}}\" target=\"_blank\">Hirdetés megtekintése</a><br><br>Sikeres felvételhez sok sikert kíván,
<br>MUMI.HU csapata<br>www.mumi.hu<br></p>','{{first_name}},{{position}},{{job_id}},{{company_profile_url}},{{company_name}},{{job_url}}', NULL, '2022-03-30 11:58:00');");
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
