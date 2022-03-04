<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddYearToMany extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('super_leaders', function (Blueprint $table) {
            $table->string('year')->after('remark');
        });
        Schema::table('middle_leaders', function (Blueprint $table) {
            $table->string('year')->after('remark');
        });
        Schema::table('lower_leaders', function (Blueprint $table) {
            $table->string('year')->after('remark');
        });
        Schema::table('first_instant_leaders', function (Blueprint $table) {
            $table->string('year')->after('remark');
        });
        Schema::table('experts', function (Blueprint $table) {
            $table->string('year')->after('remark');
        });
        Schema::table('tara_members', function (Blueprint $table) {
            $table->string('year')->after('remark');
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
            $table->dropColumn('year');
        });
        Schema::table('middle_leaders', function (Blueprint $table) {
            $table->dropColumn('year');
        });
        Schema::table('lower_leaders', function (Blueprint $table) {
            $table->dropColumn('year');
        });
        Schema::table('first_instant_leaders', function (Blueprint $table) {
            $table->dropColumn('year');
        });
        Schema::table('experts', function (Blueprint $table) {
            $table->dropColumn('year');
        });
        Schema::table('tara_members', function (Blueprint $table) {
            $table->dropColumn('year');
        });
    }
}
