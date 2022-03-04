<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class YearlySetting extends Model
{
    protected $fillable = ['code', 'type','amount'];
}
