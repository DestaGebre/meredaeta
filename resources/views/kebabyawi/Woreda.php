<?php

namespace App;
use App\Zobatat;
use App\Tabia;

use Illuminate\Database\Eloquent\Model;

class Woreda extends Model
{
  
    protected $fillable = [
        'zoneCode', 'woredacode','name','isUrban',
    ];
	
	public function zonat()
	{
	 return $this->belongsTo('App\Zobatat','zoneCode');
}
    public function woredas2()
	{
	return $this->hasMany('App\Tabia','tabiaCode');
	}
	
}
