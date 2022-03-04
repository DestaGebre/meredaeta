<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWoredasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
	
        Schema::create('woredas', function (Blueprint $table) {
		    
			// $table->increments('id');
            $table->string('zoneCode');
            $table->foreign('zoneCode')->references('zoneCode')->on('zobatats');
			$table->string('woredacode')->primary();
			$table->string('name');
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
        Schema::dropIfExists('woredas');
    }
}
