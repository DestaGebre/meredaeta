<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use  App\Hitsuy;

class Dismiss extends Model
{
    //
    protected $fillable = ['hitsuyID','dismissReason','detailReason', 'proposedBy', 'approvedBy', 'dismissDate'];
	public function hitsuydis()
	{
	 	return $this->belongsTo('App\Hitsuy','hitsuyID');
	}

}
