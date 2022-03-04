<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWorkExpriencesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('work_expriences', function (Blueprint $table) {
            $table->increments('id');
            $table->string('hitsuyID');
            $table->foreign('hitsuyID')->references('hitsuyID')->on('hitsuys');
            $table->string('exprienceType');
            $table->string('career');
            $table->string('position');
            $table->string('institute');
            $table->string('address');
            $table->date('startDate');
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
        Schema::dropIfExists('work_expriences');
    }
}
