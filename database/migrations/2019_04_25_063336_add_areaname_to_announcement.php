<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddAreanameToAnnouncement extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('announcements', function (Blueprint $table) {
            $table->text('areaname')->after('area');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('announcements', function (Blueprint $table) {
            $table->dropColumn('areaname');
        });
    }
}
