<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddSumToEvaluations extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('super_leaders', function (Blueprint $table) {
            $table->string('sum')->before('remark');
        });
        Schema::table('middle_leaders', function (Blueprint $table) {
            $table->string('sum')->before('remark');
        });
        Schema::table('experts', function (Blueprint $table) {
            $table->string('sum')->before('remark');
        });
        Schema::table('first_instant_leaders', function (Blueprint $table) {
            $table->string('sum')->before('remark');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('super_leaders', function (Blueprint $table) {
            $table->dropColumn('sum');
        });
        Schema::table('middle_leaders', function (Blueprint $table) {
            $table->dropColumn('sum');
        });
        Schema::table('experts', function (Blueprint $table) {
            $table->dropColumn('sum');
        });
        Schema::table('first_instant_leaders', function (Blueprint $table) {
            $table->dropColumn('sum');
        });
    }
}
