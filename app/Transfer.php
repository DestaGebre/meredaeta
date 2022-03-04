<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use  App\Hitsuy;

class Transfer extends Model
{
    protected $fillable = ['memberID', 'committee','dereja', 'place','reason', 'assignment','office', 
	'position', 'transferedBy','approvedBy', 'startDate','endDate','isProposed', 'approvedWudabe','partyPos'];
	public function hitsuytrans()
	{
	 	return $this->belongsTo('App\Hitsuy','hitsuyID');
	}
}