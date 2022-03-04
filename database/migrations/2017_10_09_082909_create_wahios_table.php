<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWahiosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
       Schema::create('wahios', function (Blueprint $table) {
		    
			$table->increments('id');
            $table->string('wahioName');        
            $table->string('widabeCode');			
            $table->foreign('widabeCode')->references('widabeCode')->on('meseretawi_wdabes');
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
        //
    }
}
