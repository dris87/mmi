<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCompanyAwardsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('company_awards', function (Blueprint $table) {

            $table->id();

            $table->unsignedInteger('company_id');
            $table->string('name');
            $table->string('description')->nullable();
            $table->string('award_image');

            $table->foreign('company_id')->references('id')->on('companies');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('company_awards');
    }
}
