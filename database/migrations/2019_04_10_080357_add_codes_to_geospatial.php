<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddCodesToGeospatial extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Schema::table('super_leaders', function (Blueprint $table) {
        //     $table->string('sum')->before('remark');
        // });
        // Schema::table('middle_leaders', function (Blueprint $table) {
        //     $table->string('sum')->before('remark');
        // });
        Schema::table('tabias', function (Blueprint $table) {
            $table->string('parentcode')->after('isUrban');
        });
        Schema::table('meseretawi_wdabes', function (Blueprint $table) {
            $table->string('parentcode')->after('widabeCode');
        });
        Schema::table('wahios', function (Blueprint $table) {
            $table->string('parentcode')->after('widabeCode');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Schema::table('super_leaders', function (Blueprint $table) {
        //     $table->dropColumn('sum');
        // });
        // Schema::table('middle_leaders', function (Blueprint $table) {
        //     $table->dropColumn('sum');
        // });
        Schema::table('tabias', function (Blueprint $table) {
            $table->dropColumn('parentcode');
        });
        Schema::table('meseretawi_wdabes', function (Blueprint $table) {
            $table->dropColumn('parentcode');
        });
        Schema::table('wahios', function (Blueprint $table) {
            $table->dropColumn('parentcode');
        });
    }
}
