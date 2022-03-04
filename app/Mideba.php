<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use  App\Hitsuy;
class Mideba extends Model
{
	protected $fillable = ['hithuyID', 'birkiCommittee','dereja', 'awekakla','type', 'reason','proposedBy', 
	'commentedBy', 'approvedBy', 'startDate','endDate'];
	public function hitsuymideba()
	{
	 	return $this->belongsTo('App\Hitsuy','hitsuyID');
	}
}