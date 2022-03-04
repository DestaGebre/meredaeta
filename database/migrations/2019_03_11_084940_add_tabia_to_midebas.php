<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddTabiaToMidebas extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('midebas', function (Blueprint $table) {
            $table->string('oldtabia')->after('oldworeda');
            $table->string('tabia')->after('woreda');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('midebas', function (Blueprint $table) {
            $table->dropColumn('oldworeda', 'woreda');
        });
    }
}
