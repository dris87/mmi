<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterUsersRemoveForeignKeys extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {

            //Removing the foreign keys from potentially not needed columns

            $table->dropForeign('users_country_id_foreign');
            $table->dropForeign('users_state_id_foreign');
            $table->dropForeign('users_city_id_foreign');

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
