<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TrainingSetting extends Model
{
    //
    protected $fillable = ['trainingname','trainee','traininglength','deadline'];
}
