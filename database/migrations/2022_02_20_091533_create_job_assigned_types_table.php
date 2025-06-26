<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJobAssignedTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('job_assigned_types', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('job_id');
            $table->unsignedInteger('job_type_id');
            $table->timestamps();

            $table->foreign('job_id')->references('id')->on('jobs');
            $table->foreign('job_type_id')->references('id')->on('job_types');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('job_assigned_types');
    }
}
