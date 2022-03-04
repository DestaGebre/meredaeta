<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MonthlySetting extends Model
{
    protected $fillable = ['code', 'from','to','percent'];
}
