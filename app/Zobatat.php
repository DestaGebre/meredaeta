<?php

namespace App;
use App\Woreda;

use Illuminate\Database\Eloquent\Model;

class Zobatat extends Model
{
    protected $fillable = [
        'zoneCode', 'zoneName',
    ];
	protected $primaryKey = 'zoneCode';
	public $incrementing = false;
	public function woredas2()
	{
	return $this->hasMany('App\Woreda','zoneCode');
	}
}
