<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Woreda;
use App\meseretawiWdabe;

class Tabia extends Model
{
    protected $fillable = ['woredacode', 'tabiaName','tabiaCode', 'isUrban'];
	
	public function tabiatat()
    {
        return $this->belongsTo('App\Woreda','woredacode');
		
    }
	public function meseretawiwdabe()
	{
	return $this->hasMany('App\meseretawiWdabe','tabiaCode');
	}
}
