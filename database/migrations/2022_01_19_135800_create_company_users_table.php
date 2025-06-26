<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCompanyUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('company_users', function (Blueprint $table) {

            $table->id();

            $table->bigInteger('user_id')->unsigned();
            $table->integer('company_id')->unsigned();
            $table->bigInteger('role_id')->unsigned();
            $table->bigInteger('created_by')->unsigned();

            $table->timestamps();
            $table->dropColumn('updated_at');

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('created_by')->references('id')->on('users');
            $table->foreign('company_id')->references('id')->on('companies')->onDelete('cascade');
            $table->foreign('role_id')->references('id')->on('roles')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('company_users');
    }
}
