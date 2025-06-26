<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterJobTablesModifyForeignKeys extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('job_educations', function (Blueprint $table) {
            $table->dropForeign('job_educations_job_id_foreign');
            $table->foreign('job_id')->references('id')->on('jobs')->onDelete('cascade');
        });
        Schema::table('job_experiences', function (Blueprint $table) {
            $table->dropForeign('job_experiences_job_id_foreign');
            $table->foreign('job_id')->references('id')->on('jobs')->onDelete('cascade');
        });
        Schema::table('job_driving_licenses', function (Blueprint $table) {
            $table->dropForeign('job_driving_licenses_job_id_foreign');
            $table->foreign('job_id')->references('id')->on('jobs')->onDelete('cascade');
        });
        Schema::table('job_it_skill', function (Blueprint $table) {
            $table->dropForeign('job_it_skill_job_id_foreign');
            $table->foreign('job_id')->references('id')->on('jobs')->onDelete('cascade');
        });
        Schema::table('job_software_skills', function (Blueprint $table) {
            $table->dropForeign('job_software_skills_job_id_foreign');
            $table->foreign('job_id')->references('id')->on('jobs')->onDelete('cascade');
        });
        Schema::table('job_language_skills', function (Blueprint $table) {
            $table->dropForeign('job_language_skills_job_id_foreign');
            $table->foreign('job_id')->references('id')->on('jobs')->onDelete('cascade');
        });
        Schema::table('job_locations', function (Blueprint $table) {
            $table->dropForeign('job_locations_job_id_foreign');
            $table->foreign('job_id')->references('id')->on('jobs')->onDelete('cascade');
        });
        Schema::table('job_assigned_categories', function (Blueprint $table) {
            $table->dropForeign('job_assigned_categories_job_id_foreign');
            $table->foreign('job_id')->references('id')->on('jobs')->onDelete('cascade');
        });
        Schema::table('job_assigned_types', function (Blueprint $table) {
            $table->dropForeign('job_assigned_types_job_id_foreign');
            $table->foreign('job_id')->references('id')->on('jobs')->onDelete('cascade');
        });
        Schema::table('job_assigned_shifts', function (Blueprint $table) {
            $table->dropForeign('job_assigned_shifts_job_id_foreign');
            $table->foreign('job_id')->references('id')->on('jobs')->onDelete('cascade');
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
