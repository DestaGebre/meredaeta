<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateApprovedHitsuysTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('approved_hitsuys', function (Blueprint $table) {
            // $table->increments('id');
            $table->string('hitsuyID')->primary();
            $table->foreign('hitsuyID')->references('hitsuyID')->on('hitsuys');
            $table->date('membershipDate');            
            $table->string('membershipType');
            $table->string('zoneworedaCode'); //from ID zoneworeda code
            $table->decimal('grossSalary',10,2);
            $table->decimal('netSalary',10,2);
            $table->string('assignedWudabe');
            $table->string('assignedWahio'); 
            $table->string('assignedAssoc');               
            $table->string('wahioposition')->default('ተራ ኣባል');  
            $table->string('meseratawiposition')->default('ተራ ኣባል');  
            $table->string('fileNumber'); 
            $table->string('memberType')->default('ተራ ኣባል'); 
            $table->string('approved_status')->default('1'); //ዝተሰናበተ //ዝተባረረ //ዝተኣገደ //ናብ ሕፁይነት ዝወረደ //ዝተዛወረ //ዝተመደበ
            $table->boolean('isReported');
            $table->boolean('hasRequested');
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
        Schema::dropIfExists('approved_hitsuys');
    }
}
