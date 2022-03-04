<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGiftsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('gifts', function (Blueprint $table) {
            $table->increments('id');
            $table->string('donorId');
            $table->foreign('donorId')->references('donorId')->on('donors');
			$table->string('giftType');
			$table->string('purpose');
			$table->string('giftName');
			$table->string('valuation');
			$table->string('status');
			$table->date('donationDate');			
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
        Schema::dropIfExists('gifts');
    }
}
