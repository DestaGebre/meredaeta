<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSiltenasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('siltenas', function (Blueprint $table) {
            $table->increments('id');
            $table->string('hitsuyID');
            $table->foreign('hitsuyID')->references('hitsuyID')->on('hitsuys');
            $table->string('trainingLevel');
            $table->string('trainer');
            $table->date('startDate');
            $table->date('endDate');
            $table->string('numDays');
            $table->string('trainingPlace');
            $table->string('trainingType');            
            $table->boolean('zoneDecision');
            $table->boolean('woredaApproved');
            $table->boolean('zoneApproved');
            $table->boolean('officeApproved');
            $table->boolean('isDocumented');
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
        Schema::dropIfExists('siltenas');
    }
}
