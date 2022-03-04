<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Termination extends Model
{
   protected $fillable = [
        'memberID', 'reason', 'proposedBy', 'approvedBy', 'terminationDate'];
}
