<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterJobsTableDropColumns extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('jobs', function (Blueprint $table) {

            $table->dropForeign('jobs_country_id_foreign');
            $table->dropForeign('jobs_state_id_foreign');
            $table->dropForeign('jobs_city_id_foreign');
            $table->dropForeign('jobs_job_category_id_foreign');
            $table->dropForeign('jobs_currency_id_foreign');
            $table->dropForeign('jobs_salary_period_id_foreign');
            $table->dropForeign('jobs_job_type_id_foreign');
            $table->dropForeign('jobs_career_level_id_foreign');
            $table->dropForeign('jobs_functional_area_id_foreign');
            $table->dropForeign('jobs_job_shift_id_foreign');
            $table->dropForeign('jobs_degree_level_id_foreign');

            $table->dropColumn('country_id');
            $table->dropColumn('state_id');
            $table->dropColumn('city_id');
            $table->dropColumn('salary_from');
            $table->dropColumn('salary_to');
            $table->dropColumn('job_category_id');
            $table->dropColumn('currency_id');
            $table->dropColumn('salary_period_id');
            $table->dropColumn('job_type_id');
            $table->dropColumn('career_level_id');
            $table->dropColumn('functional_area_id');
            $table->dropColumn('job_shift_id');
            $table->dropColumn('degree_level_id');
            $table->dropColumn('no_preference');
            $table->dropColumn('hide_salary');
            $table->dropColumn('is_freelance');
            $table->dropColumn('experience');

        });
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
