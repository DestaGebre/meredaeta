<?php

namespace App;
use App\Donor;
use Illuminate\Database\Eloquent\Model;

class Gift extends Model
{
     protected $fillable = ['donorId','giftType', 'purpose', 'giftName', 'valuation', 'status', 'donationDate'];
     public function donor(){
		return $this->belongsTo('App\Donor','donorId');
	}
}
