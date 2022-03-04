<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTerminationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('terminations', function (Blueprint $table) {        
            $table->string('hitsuyID')->primary();
            $table->foreign('hitsuyID')->references('hitsuyID')->on('hitsuys');
			$table->string('reason');
			$table->string('proposedBy');
			$table->string('approvedBy');
			$table->date('terminationDate');
			$table->string('isReported');
			$table->string('isApproved');
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
        Schema::dropIfExists('terminations');
    }
}
