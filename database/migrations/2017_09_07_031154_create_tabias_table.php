<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTabiasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tabias', function (Blueprint $table) {
            // $table->increments('tid');
			$table->string('woredacode');
			$table->foreign('woredacode')->references('woredacode')->on('woredas');
			$table->string('tabiaName');
			$table->string('tabiaCode')->primary();
			$table->string('isUrban');
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
        Schema::dropIfExists('tabias');
    }
}
