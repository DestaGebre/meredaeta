<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTaraMembersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tara_members', function (Blueprint $table) {
            $table->increments('id');
            $table->string('hitsuyID');
             $table->foreign('hitsuyID')->references('hitsuyID')->on('hitsuys');
            // $table->integer('yearEval')->unsigned();
            $table->string('model');
            $table->string('evaluation');
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
        Schema::dropIfExists('tara_members');
    }
}
