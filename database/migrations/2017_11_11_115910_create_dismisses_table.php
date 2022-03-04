<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDismissesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dismisses', function (Blueprint $table) {
            $table->increments('id');
            $table->string('hitsuyID');
            $table->foreign('hitsuyID')->references('hitsuyID')->on('hitsuys');
            $table->string('dismissReason');
            $table->text('detailReason');
            $table->string('proposedBy');
            $table->string('approvedBy');
            $table->date('dismissDate');
            $table->boolean('isReported');
            $table->boolean('isApproved');

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
        Schema::dropIfExists('dismisses');
    }
}
