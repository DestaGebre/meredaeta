<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddTypeToWidabeAndWahio extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('meseretawi_wdabes', function (Blueprint $table) {
            $table->string('type')->after('widabeName')->nullable();
        });
        Schema::table('wahios', function (Blueprint $table) {
            $table->string('type')->after('wahioName')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('meseretawi_wdabes', function (Blueprint $table) {
            $table->dropColumn('type');
        });
        Schema::table('wahios', function (Blueprint $table) {
            $table->dropColumn('type');
        });
    }
}
