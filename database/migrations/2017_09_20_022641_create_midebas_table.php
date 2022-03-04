<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMidebasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('midebas', function (Blueprint $table) {
            $table->increments('id');
            $table->string('hitsuyID');
            $table->foreign('hitsuyID')->references('hitsuyID')->on('hitsuys');
			$table->string('birkiCommittee');
			$table->string('deraja');
			$table->string('awekakla');
			$table->string('type');
			$table->string('reason');
            
            $table->string('zone');
            $table->string('woreda');
            $table->string('assignedWudabe');
            $table->string('assignedWahio');
            $table->string('oldzone');
            $table->string('oldworeda');
            $table->string('oldassignedWudabe');
            $table->string('oldassignedWahio');

			$table->string('proposedBy');
			$table->string('commentedBy');
			$table->string('approvedBy');
			$table->date('startDate');
			$table->date('endDate');
			$table->boolean('isProposed');
			$table->boolean('approvedWudabe');
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
        Schema::dropIfExists('midebas');
    }
}
