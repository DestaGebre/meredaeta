<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFirstInstantLeadersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('first_instant_leaders', function (Blueprint $table) {
            $table->increments('id');
            $table->string('hitsuyID');
             $table->foreign('hitsuyID')->references('hitsuyID')->on('hitsuys');
            // $table->integer('yearEval')->unsigned();
            $table->text('answer1');
            $table->text('answer2');
            $table->text('answer3');
            $table->text('answer4');
            $table->text('answer5');
            $table->text('answer6');
            $table->text('answer7');
            $table->text('answer8');
            $table->text('answer9');
            $table->text('answer10');
            $table->text('answer11');
            $table->text('answer12');
            $table->string('result1');
            $table->string('result2');
            $table->string('result3');
            $table->string('result4');
            $table->string('result5');
            $table->string('result6');
            $table->string('result7');
            $table->string('result8');
            $table->string('result9');
            $table->string('result10');
            $table->text('remark');
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
        Schema::dropIfExists('first_instant_leaders');
    }
}
