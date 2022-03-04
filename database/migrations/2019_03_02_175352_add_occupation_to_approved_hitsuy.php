<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddOccupationToApprovedHitsuy extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('approved_hitsuys', function (Blueprint $table) {
            $table->string('occupation')->after('gender');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('approved_hitsuys', function (Blueprint $table) {
            $table->dropColumn('occupation');
        });
    }
}
