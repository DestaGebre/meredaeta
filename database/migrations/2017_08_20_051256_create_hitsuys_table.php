<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHitsuysTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hitsuys', function (Blueprint $table) {
            // $table->increments('id');
            $table->string('hitsuyID')->primary(); //primary key
			$table->string('name');
			$table->string('fname');
			$table->string('gfname');
			$table->string('gender');
			$table->string('birthPlace');
			$table->date('dob');
			$table->string('occupation');
			$table->string('position');
			$table->string('sme')->nullable();
			$table->date('regDate');
			$table->string('proposerWidabe');
			$table->string('proposerWahio');
			$table->string('proposerMem');
			$table->string('fileNumber');
			$table->string('region');
			$table->string('tabiaID')->nullable();
			$table->string('address')->nullable();
			$table->string('tell');
			$table->string('email');
			$table->boolean('isRequested');
			$table->boolean('hasPermission');
			$table->boolean('isWilling');
			$table->boolean('isReportedWahioHalafi');
			$table->boolean('isReportedWahioMem');
			$table->string('hitsuy_status')->default('ሕፁይ'); //ሕፁይነት ተናዊሑ //ኣባል //ካብ ሕፁይነት ዝተባረረ //ዝተሰናበተ //ሕፁይ //ካብ ኣባልነት ዝተባረረ
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
        Schema::dropIfExists('hitsuys');
    }
}
