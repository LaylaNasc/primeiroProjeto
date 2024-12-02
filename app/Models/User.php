<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
   public function notas(){
        return $this->hasMany(Note::class); 
   }

}
