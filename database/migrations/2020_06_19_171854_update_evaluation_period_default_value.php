<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateEvaluationPeriodDefaultValue extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('super_leaders', function (Blueprint $table) {
            $table->string('half')->default('ዓመት')->change();
        });
        Schema::table('middle_leaders', function (Blueprint $table) {
            $table->string('half')->default('ዓመት')->change();
        });
        Schema::table('lower_leaders', function (Blueprint $table) {
            $table->string('half')->default('ዓመት')->change();
        });
        Schema::table('first_instant_leaders', function (Blueprint $table) {
            $table->string('half')->default('ዓመት')->change();
        });
        Schema::table('experts', function (Blueprint $table) {
            $table->string('half')->default('ዓመት')->change();
        });
        Schema::table('tara_members', function (Blueprint $table) {
            $table->string('half')->default('ዓመት')->change();
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
