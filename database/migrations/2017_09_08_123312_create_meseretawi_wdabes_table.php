<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMeseretawiWdabesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('meseretawi_wdabes', function (Blueprint $table) {
            //$table->increments('id');
			$table->string('tabiaCode');
			$table->foreign('tabiaCode')->references('tabiaCode')->on('tabias');
			$table->string('widabeName');
			$table->string('widabeCode')->primary();
			
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
        Schema::dropIfExists('meseretawi_wdabes');
    }
}
