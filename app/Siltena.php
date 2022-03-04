<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use  App\Hitsuy;

class Siltena extends Model
{
    //
    protected $fillable = ['trainingLevel', 'trainer', 'startDate','endDate', 'numDays', 'trainingPlace', 'trainingType'];
   
	public function hitsuytraining()
	{
	 	return $this->belongsTo('App\Hitsuy','hitsuyID');
	}
}
