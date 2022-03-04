<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCareerInformationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('career_informations', function (Blueprint $table) {
            $table->increments('id');
            $table->string('hitsuyID');
            $table->foreign('hitsuyID')->references('hitsuyID')->on('hitsuys');
            $table->string('exprienceType');
            $table->string('career');
            $table->string('position');
            $table->string('institute');
            $table->string('address');
            $table->date('startDate');
            $table->date('endDate')->nullable();
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
        Schema::dropIfExists('career_informations');
    }
}
