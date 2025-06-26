<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBackofficeUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('backoffice_users', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->string('first_name');
            $table->string('last_name');
            $table->string('email', 170)->unique();
            $table->date('dob')->nullable();
            $table->string('phone')->nullable();
            $table->string('notified_name')->nullable();
            $table->string('notified_phone')->nullable();

            
            $table->unsignedBigInteger('superior_id')->nullable();
            $table->unsignedBigInteger('branch_office_id');
            $table->unsignedBigInteger('position_id');
            $table->unsignedBigInteger('main_permission_id')->nullable();
            $table->timestamps();

            $table->foreign('superior_id')->references('id')->on('backoffice_users');

            $table->foreign('position_id')->references('id')->on('backoffice_positions');

            $table->foreign('branch_office_id')->references('id')->on('branch_offices');

            $table->foreign('main_permission_id')->references('id')->on('permissions')
                    ->onDelete('set null')
                    ->onUpdate('cascade');

            $table->foreign('user_id')->references('id')->on('users');
        });

        
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('backoffice_users');
    }
}
