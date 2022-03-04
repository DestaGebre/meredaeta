<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRejectedHitsuysTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rejected_hitsuys', function (Blueprint $table) {
            $table->string('hitsuyID')->primary();
            $table->foreign('hitsuyID')->references('hitsuyID')->on('hitsuys');
            $table->string('rejectionReason');
            $table->date('rejectionDate');
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
        Schema::dropIfExists('rejected_hitsuys');
    }
}
