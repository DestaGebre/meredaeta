<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMewachoSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mewacho_settings', function (Blueprint $table) {
            $table->increments('id');
			$table->string('name');
			$table->string('purpose');
			$table->string('mtype');
			$table->decimal('amount',10,2);
			$table->date('deadline');
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
        Schema::dropIfExists('mewacho_settings');
    }
}
