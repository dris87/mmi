<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBackofficeUserExtraPermissionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('backoffice_user_extra_permissions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('backoffice_user_id');
            $table->unsignedBigInteger('permission_id');
            $table->timestamps();

            $table->foreign('backoffice_user_id')->references('id')->on('backoffice_users')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->foreign('permission_id')->references('id')->on('permissions')
                ->onDelete('cascade')
                ->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('backoffice_user_extra_permissions');
    }
}
