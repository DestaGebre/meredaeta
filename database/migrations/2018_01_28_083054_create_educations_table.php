<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEducationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
         Schema::create('educations', function (Blueprint $table) {
            $table->increments('id');
            $table->string('hitsuyID');
             $table->foreign('hitsuyID')->references('hitsuyID')->on('hitsuys');
            // $table->integer('yearEval')->unsigned();
            $table->string('educationType');
            $table->string('educationLevel');
            $table->string('institute');
            $table->date('graduationDate');
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
        Schema::dropIfExists('educations');
    }
}
