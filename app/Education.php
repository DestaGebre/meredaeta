<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use  App\Hitsuy;
class Education extends Model
{
     protected $fillable = ['hitsuyID','educationType','educationLevel', 'institute', 'graduationDate'];
	public function hitsuyedu()
	{
	 	return $this->belongsTo('App\Hitsuy','hitsuyID');
	}

}
