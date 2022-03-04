<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWoredaplansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('woredaplans', function (Blueprint $table) {
            $table->increments('id');
            $table->string('woredacode');
            $table->string('planyear');
            $table->string('plantype');
            $table->string('amount');            
            $table->text('descrpt');
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
        Schema::dropIfExists('woredaplans');
    }
}
