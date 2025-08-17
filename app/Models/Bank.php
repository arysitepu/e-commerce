<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Bank extends Model
{
     protected $table = 'banks';

     public function rekening()
     {
          return $this->hasMany(Rekening::class);
     }
}
