<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCompanyVideosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('company_videos', function (Blueprint $table) {

            $table->id();

            $table->unsignedInteger('company_id');
            $table->string('video_url');
            $table->string('title');
            $table->string('description')->nullable();
            $table->string('thumbnail');

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
        Schema::dropIfExists('company_videos');
    }
}
