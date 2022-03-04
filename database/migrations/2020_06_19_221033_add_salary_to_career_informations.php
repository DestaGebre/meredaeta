<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddSalaryToCareerInformations extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('career_informations', function (Blueprint $table) {
            $table->decimal('salary',10,2)->after('position');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('career_informations', function (Blueprint $table) {
            $table->dropColumn('salary');
        });
    }
}
