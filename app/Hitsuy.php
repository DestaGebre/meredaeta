<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\ApprovedHitsuy;
use App\RejectedHitsuy;
use App\NotyetHitsuy;
use App\Penalty;
use App\Siltena;
use App\MiddleLeader;

class Hitsuy extends Model
{
    protected $fillable = ['name', 'fname', 'gfName','gender','birthPlace', 'dob','occupation', 
	'position', 'regDate','proposerWidabe', 'proposerWahio','proposerMem','fileNumber', 'region','isRequested','hasPermission', 'isWilling','isReportedWahioHalafi', 'isReportedWahioMem'];

	//PK is id and it's incrementing
	protected $primaryKey = 'hitsuyID';
	public $incrementing = false;

	public function approvedhitsuy(){
		return $this->hasOne('App\ApprovedHitsuy','hitsuyID');
	}
	public function rejectedhitsuy(){
		return $this->hasOne('App\RejectedHitsuy','hitsuyID');
	}
	public function notyethitsuy(){
		return $this->hasOne('App\NotyetHitsuy','hitsuyID');
	}
	public function penalty(){
		return $this->hasMany('App\Penalty','hitsuyID');
	}
	public function training(){
		return $this->hasMany('App\Siltena','hitsuyID');
	}
	public function mleaderseval(){
		return $this->hasMany('App\MiddleLeader','hitsuyID');
	}
}