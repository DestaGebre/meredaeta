<?php

namespace App;
use App\Gift;
use Illuminate\Database\Eloquent\Model;

class Donor extends Model
{
    protected $fillable = ['donorId', 'donorType', 'donorName', 'occupationArea', 'address'];
    protected $primaryKey = 'donorId';
	public $incrementing = false;
	public function gift(){
		return $this->hasMany('App\Gift','donorId');
	}
}
