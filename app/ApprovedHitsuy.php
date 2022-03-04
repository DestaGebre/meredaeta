<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use  App\Hitsuy;

class ApprovedHitsuy extends Model
{
    //
    protected $fillable = ['membershipDate', 'membershipType','netSalary','assignedWudabe','memberType'];
	
	public function hitsuy(){
		 return $this->belongsTo('App\Hitsuy','hitsuyID');
	}    
}
