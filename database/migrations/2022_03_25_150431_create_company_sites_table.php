<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCompanySitesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('company_sites', function (Blueprint $table) {

            $table->id();

            $table->unsignedInteger('company_id');
            $table->unsignedInteger('postcode_id');
            $table->unsignedBigInteger('city_id');
            $table->string('street');
            $table->string('address');
            $table->string('floor')->nullable();
            $table->string('door')->nullable();

            $table->foreign('postcode_id')->references('id')->on('postal_codes');
            $table->foreign('city_id')->references('id')->on('cities');
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
        Schema::dropIfExists('company_sites');
    }
}
