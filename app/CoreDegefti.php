<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class CoreDegefti extends Model
{
   protected $fillable = ['name', 'fname', 'gfName','gender','birthPlace', 'dob','position', 
	'occupation', 'coreDegafiregDate','proposerMem', 'degaficonfirmedWidabe','assignedWidabe','participatedCommittee', 'degafiparticipationinCommittee','address','tell', 'poBox','fileNumber', 'email' ,'bosSubmittedTsebtsab' ,'widabeacceptedDegafi'];
   

	//PK is id and it's incrementing
	
}
