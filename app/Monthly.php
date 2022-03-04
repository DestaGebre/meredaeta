<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Monthly extends Model
{
    protected $fillable = ['hitsuyID','month','year','amount'];
}