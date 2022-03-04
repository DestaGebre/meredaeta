<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddEndDateToWorkExprience extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('work_expriences', function (Blueprint $table) {
            $table->date('endDate')->after('startDate')->default(null);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('work_expriences', function (Blueprint $table) {
            $table->dropColumn('endDate');
        });
    }
}
