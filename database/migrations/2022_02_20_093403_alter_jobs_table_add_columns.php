<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterJobsTableAddColumns extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('jobs', function (Blueprint $table) {
            $table->string('advantages')->nullable()->after('description');
            $table->string('tasks')->nullable()->after('description');
            $table->string('perks')->nullable()->after('description');
            $table->string('candidate_count')->nullable()->after('position');
            $table->tinyInteger('is_anonym')->default(0);
            $table->date('job_release_date')->after('job_expiry_date');
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
