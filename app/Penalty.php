<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use  App\Hitsuy;

class Penalty extends Model
{
	 // protected $table = 'penalties';
    protected $fillable = ['chargeType', 'chargeLevel', 'penaltyGiven', 'proposedBy', 'approvedBy', 'duration', 'startDate'];
    

	public function hitsuypen()
	{
	 	return $this->belongsTo('App\Hitsuy','hitsuyID');
	}

}
