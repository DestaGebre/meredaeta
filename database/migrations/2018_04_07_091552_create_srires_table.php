<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSriresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('srires', function (Blueprint $table) {
            $table->increments('id');
            $table->string('type'); //ወረዳ፣ መው፣ ዋህዮ
            $table->string('code'); //code of woreda...
            $table->string('result');
            $table->string('year');
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
        Schema::dropIfExists('srires');
    }
}
