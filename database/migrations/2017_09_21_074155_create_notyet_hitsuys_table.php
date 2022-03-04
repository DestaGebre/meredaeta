<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNotyetHitsuysTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('notyet_hitsuys', function (Blueprint $table) {
            $table->string('hitsuyID')->primary();
            $table->foreign('hitsuyID')->references('hitsuyID')->on('hitsuys');
            $table->date('postponedDate');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('notyet_hitsuys');
    }
}
