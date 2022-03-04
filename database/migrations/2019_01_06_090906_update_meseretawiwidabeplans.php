<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateMeseretawiwidabeplans extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('meseretawiwidabeaplans', function (Blueprint $table) {
            $table->dropColumn('plantype', 'amount', 'descrpt');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('meseretawiwidabeaplans', function (Blueprint $table) {
            $table->string('plantype');
            $table->string('amount');            
            $table->text('descrpt');
        });
    }
}
