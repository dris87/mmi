<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterCompaniesTableAddCompanyDetails extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('companies', function (Blueprint $table) {

            $table->string('vatNumber');

            //Has to be nullable to prevent issues with existing records
            $table->integer('postcode_id')->unsigned()->nullable();
            $table->bigInteger('city_id')->unsigned()->nullable();

            $table->string('address');
            $table->string('floor')->nullable();
            $table->string('door')->nullable();

            $table->foreign('postcode_id')->references('id')->on('postal_codes');
            $table->foreign('city_id')->references('id')->on('cities');
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
