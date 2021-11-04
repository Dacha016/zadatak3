<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Assignment extends Model
{

    protected $guarded=[];

    public function groups(){
        return $this->hasMany(Group::class);
    }
    public function interns(){
        return $this->hasMany(Intern::class);
    }

}
