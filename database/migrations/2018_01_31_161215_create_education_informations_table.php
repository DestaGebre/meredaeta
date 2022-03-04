<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEducationInformationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('education_informations', function (Blueprint $table) {
            $table->increments('id');
            $table->string('hitsuyID');
            $table->foreign('hitsuyID')->references('hitsuyID')->on('hitsuys');
            $table->string('educationType');
            $table->string('educationLevel');
            $table->string('institute');
            $table->string('graduationDate');
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
        Schema::dropIfExists('education_informations');
    }
}
