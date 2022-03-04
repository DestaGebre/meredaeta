<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TaraMember extends Model
{
    protected $fillable = ['hitsuy_id','model','evaluation','remark'];
    public function hitsuy(){
		 return $this->belongsTo('App\Hitsuy','hitsuyID');
	}
}
