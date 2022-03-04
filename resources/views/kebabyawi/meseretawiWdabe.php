<?php

namespace App;
use App\Tabia;

use Illuminate\Database\Eloquent\Model;

class meseretawiWdabe extends Model
{
     protected $fillable = ['tabiaCode', 'widabeName','widabeCode'];
	
	public function widabes()
    {
        return $this->belongsTo('App\Tabia','tabiaCode');
		
    }
}
