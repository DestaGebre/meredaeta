<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePenaltiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('penalties', function (Blueprint $table) {
            $table->increments('id');
            $table->string('hitsuyID');
            $table->foreign('hitsuyID')->references('hitsuyID')->on('hitsuys');
			$table->string('chargeType');
			$table->string('chargeLevel');
			$table->string('penaltyGiven');
			$table->string('proposedBy');
			$table->string('approvedBy');
			$table->string('duration');
			$table->date('startDate');
			$table->boolean('isReported');
			$table->boolean('isApproved');
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
        Schema::dropIfExists('penalties');
    }
}
