<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterTableCompaniesDropColumns extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('companies', function (Blueprint $table) {
            $table->dropColumn('ceo');
            $table->dropColumn('no_of_offices');
            $table->dropColumn('industry_id');
            $table->dropColumn('ownership_type_id');
            $table->dropColumn('company_size_id');
            $table->dropColumn('established_in');
            $table->dropColumn('details');
            $table->dropColumn('website');
            $table->dropColumn('location');
            $table->dropColumn('location2');
            $table->dropColumn('fax');
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
