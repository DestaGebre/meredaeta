<?php

namespace App;
use App\Tabia;
use App\Wahio;

use Illuminate\Database\Eloquent\Model;

class meseretawiWdabe extends Model
{
     protected $fillable = ['tabiaCode', 'widabeName','widabeCode'];
     protected $primaryKey = 'widabeCode';
	public $incrementing = false;
	
	public function widabes()
    {
        return $this->belongsTo('App\Tabia','tabiaCode');
		
    }
    public function wahio()
	{
		return $this->hasMany('App\Wahio');
	}
}
