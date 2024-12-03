<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Note extends Model
{
    use SoftDeletes;

    protected $table = 'notas';
    
    public function user(){
        return $this->belongsTo(User::class);
    }
}
