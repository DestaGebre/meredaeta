<?php

use Kamaln7\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Auth;

namespace App;
use  App\Zobatat;
use  App\Woreda; 
use  App\Tabia;
use  App\meseretawiWdabe;

use Illuminate\Database\Eloquent\Model;

class Wahio extends Model
{
     protected $fillable =  ['wahioName', 'widabeCode','wahioName'];
     
	 public function wahiosmw()
    {
        return $this->belongsTo('App\meseretawiWdabe','widabeCode');
		
    }
	
	
}
