<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTransfersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transfers', function (Blueprint $table) {
            $table->increments('id');
            $table->string('hitsuyID');
            $table->foreign('hitsuyID')->references('hitsuyID')->on('hitsuys');
			$table->string('committee');
			$table->string('dereja');
			$table->string('place');

            $table->string('zone');
            $table->string('woreda');
            $table->string('assignedWudabe');
            $table->string('assignedWahio');
            $table->string('oldzone');
            $table->string('oldworeda');
            $table->string('oldassignedWudabe');
            $table->string('oldassignedWahio');
            
			$table->string('reason');
			$table->string('assignment');
			$table->string('office');
			$table->string('position');
			$table->string('transferedBy');
			$table->string('approvedBy');
			$table->date('startDate');
			$table->date('endDate');
			$table->boolean('isProposed');
			$table->boolean('approvedWudabe');
			$table->boolean('partyPos');
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
        Schema::dropIfExists('transfers');
    }
}
