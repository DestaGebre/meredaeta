<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddHalfToEvaluation extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('super_leaders', function (Blueprint $table) {
            $table->string('half')->after('year');
        });
        Schema::table('middle_leaders', function (Blueprint $table) {
            $table->string('half')->after('year');
        });
        Schema::table('lower_leaders', function (Blueprint $table) {
            $table->string('half')->after('year');
        });
        Schema::table('first_instant_leaders', function (Blueprint $table) {
            $table->string('half')->after('year');
        });
        Schema::table('experts', function (Blueprint $table) {
            $table->string('half')->after('year');
        });
        Schema::table('tara_members', function (Blueprint $table) {
            $table->string('half')->after('year');
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
            $table->dropColumn('half');
        });
        Schema::table('middle_leaders', function (Blueprint $table) {
            $table->dropColumn('half');
        });
        Schema::table('lower_leaders', function (Blueprint $table) {
            $table->dropColumn('half');
        });
        Schema::table('first_instant_leaders', function (Blueprint $table) {
            $table->dropColumn('half');
        });
        Schema::table('experts', function (Blueprint $table) {
            $table->dropColumn('half');
        });
        Schema::table('tara_members', function (Blueprint $table) {
            $table->dropColumn('half');
        });
    }
}
