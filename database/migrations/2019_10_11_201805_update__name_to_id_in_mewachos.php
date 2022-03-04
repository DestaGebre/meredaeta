<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateNameToIdInMewachos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('mewachos', function (Blueprint $table) {
            $table->integer('mewacho_name')->change();
            $table->renameColumn('mewacho_name','mewacho_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('mewachos', function (Blueprint $table) {
            $table->string('mewacho_id')->change();
            $table->renameColumn('mewacho_id','mewacho_name');
        });
    }
}
