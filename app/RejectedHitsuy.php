<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Hitsuy;

class RejectedHitsuy extends Model
{
    //
    protected $fillable = ['rejectionReason', 'rejectionDate'];

    public function hitsuy(){
		 return $this->belongsTo('App\Hitsuy','hitsuyID');
	}
}
