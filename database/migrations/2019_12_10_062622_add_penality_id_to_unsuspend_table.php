<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddPenalityIdToUnsuspendTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('unsuspend', function (Blueprint $table) {
            $table->integer('penalityid')->after('hitsuyID');
            // $table->foreign('penalityid')->references('id')->on('penalties');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('unsuspend', function (Blueprint $table) {
            $table->dropColumn('penalityid');
        });
    }
}
