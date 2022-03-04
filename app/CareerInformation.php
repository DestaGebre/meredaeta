<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use  App\Hitsuy;
class CareerInformation extends Model
{
    protected $fillable = ['hitsuyID','exprienceType','career','position', 'institute', 'address','startDate'];
	public function hitsuyexp()
	{
	 	return $this->belongsTo('App\Hitsuy','hitsuyID');
	}
}

