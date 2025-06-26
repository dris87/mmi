<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterCompanyUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('company_users', function (Blueprint $table) {

            $table->dropForeign('company_users_role_id_foreign');
            $table->dropColumn('role_id');

            $table->unsignedBigInteger('permission_id');
            $table->unsignedBigInteger('coworker_position_id');
            $table->unsignedBigInteger('company_site_id')->nullable();
            $table->string('phone', 200)->nullable();
            $table->boolean('is_active')->default(true);
            $table->datetime('last_login')->default(null)->nullable();

            $table->foreign('permission_id')->references('id')->on('permissions')->onDelete('cascade');
            $table->foreign('company_site_id')->references('id')->on('company_sites')->onDelete('cascade');
            $table->foreign('coworker_position_id')->references('id')->on('coworker_positions')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('company_users', function (Blueprint $table) {

            $table->dropForeign('company_users_permission_id_foreign');
            $table->dropForeign('company_users_company_site_id_foreign');
            $table->dropForeign('company_users_coworker_position_id_foreign');
            $table->dropColumn('permission_id');
            $table->dropColumn('coworker_position_id');
            $table->dropColumn('phone');
            $table->dropColumn('company_site_id');
            $table->dropColumn('is_active');
            $table->dropColumn('last_login');

            $table->unsignedbigInteger('role_id');
            $table->foreign('role_id')->references('id')->on('roles')->onDelete('cascade');
        });
    }
}
