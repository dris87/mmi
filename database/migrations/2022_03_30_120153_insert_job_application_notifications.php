<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class InsertJobApplicationNotifications extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement("INSERT INTO `email_templates` (`id`, `template_name`, `subject`, `body`, `variables`, `created_at`, `updated_at`) VALUES (NULL, 'Job Application Candidate', 'Sikeres jelentkezés a(z) {{position}} álláshirdetésre', '<p align=\"left\">Tisztelt {{first_name}}!<br><br>Sikeresen jelentkezett a(z) {{position}} álláshirdetésre.<br><br>Pozicíó megnevezése: {{position}}<br>Cég neve: {{company_name}}</p><p align=\"left\"><a href=\"{{company_profile_url}}\" target=\"_blank\">Cégprofil megtekintése</a><br> <a href=\"{{job_url}}\" target=\"_blank\">Hirdetés megtekintése</a><br><br>Sikeres felvételhez sok sikert kíván,<br>MUMI.HU csapata<br>www.mumi.hu<br></p>', '{{first_name}},{{position}},{{job_id}},{{company_profile_url}},{{company_name}},{{job_url}}', NULL, '2022-03-30 11:58:00');");
        DB::statement("INSERT INTO `email_templates` (`id`, `template_name`, `subject`, `body`, `variables`, `created_at`, `updated_at`) VALUES (NULL, 'Job Application Employer', 'Új jelentkezés a(z) {{position}} álláshirdetésre', '<p align=\"left\">Tisztelt {{first_name}}!<br><br>Egy új álláskereső jelentkezett a(z) {{position}} álláshirdetésére.<br>A jelentkezés részletei megtekinthetőek a kezelőfelületen.<br><br>Sikeres felvételhez sok sikert kíván,<br>MUMI.HU csapata<br>www.mumi.hu<br></p>', '{{first_name}},{{position}},{{job_id}},{{company_profile_url}},{{company_name}}{{first_name}},{{position}},{{job_id}},{{company_profile_url}},{{company_name}},{{job_url}}', NULL, '2022-03-30 11:59:10');");
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
