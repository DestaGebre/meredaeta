<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCoreDegeftisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('core_degeftis', function (Blueprint $table) {
             $table->increments('id');
			$table->string('name');
			$table->string('fname');
			$table->string('gfname');
			$table->string('gender');
			$table->string('birthPlace');
			$table->date('dob');
			$table->string('position');
			$table->string('occupation');
			//$table->string('sme')->nullable();
			$table->date('coreDegafiregDate');
			$table->string('proposerMem');
			$table->string('degaficonfirmedWidabe');
			$table->string('assignedWidabe');
			$table->string('participatedCommittee');
			$table->string('degafiparticipationinCommittee');
			//$table->string('tabiaID')->nullable();
			$table->string('address')->nullable();
			$table->string('tell');
			$table->string('poBox');
			$table->string('fileNumber');
			$table->string('email');
			$table->boolean('bosSubmittedTsebtsab');
			$table->boolean('widabeacceptedDegafi');			
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
        Schema::dropIfExists('core_degeftis');
    }
}
