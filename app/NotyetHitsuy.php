<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Hitsuy;

class NotyetHitsuy extends Model
{
    //
    protected $fillable = ['postponedDate'];

    public function hitsuy(){
		 return $this->belongsTo('App\Hitsuy','hitsuyID');
	}
}
