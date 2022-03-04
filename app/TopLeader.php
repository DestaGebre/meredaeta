<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Hitsuy;
class TopLeader extends Model
{
    //
    protected $fillable = ['hitsuy_id','answer1','answer2','answer3','answer4','answer5','answer6','answer7','answer8','answer9','answer10','answer11','answer12','answer13','answer14','answer15','result1','result2','result3','result4','result5','result6','result7','result8','result9','result10','result11','result12','result13','remark'];
   //protected $primaryKey = 'hitsuyID';
    public function hitsuy(){
		 return $this->belongsTo('App\Hitsuy','hitsuyID');
	}
}
