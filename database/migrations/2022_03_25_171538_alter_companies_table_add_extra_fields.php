<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterCompaniesTableAddExtraFields extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('companies', function (Blueprint $table) {
            $table->string('display_name')->nullable()->after('name');
            $table->string('logo')->nullable()->after('door');
            $table->string('cover_photo')->nullable();
            $table->string('website')->nullable();
            $table->string('facebook_url')->nullable();
            $table->string('linkedin_url')->nullable();
            $table->string('google_plus_url')->nullable();
            $table->unsignedInteger('industry_id')->nullable();
            $table->integer('company_size')->nullable();
            $table->integer('established_in')->nullable();
            $table->text('introduction')->nullable();
            $table->text('mission')->nullable();
            $table->text('why_work_with_us')->nullable();
            $table->text('workplace_image')->nullable();
            $table->tinyInteger('is_paper_invoice')->default(0);
            $table->integer('mailing_postcode_id')->unsigned()->nullable();
            $table->bigInteger('mailing_city_id')->unsigned()->nullable();

            $table->string('mailing_address');
            $table->string('mailing_floor')->nullable();
            $table->string('mailing_door')->nullable();

            $table->foreign('mailing_postcode_id')->references('id')->on('postal_codes');
            $table->foreign('mailing_city_id')->references('id')->on('cities');

            $table->foreign('industry_id')->references('id')->on('industries');

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
