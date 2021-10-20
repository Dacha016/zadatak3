<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Intern extends Model
{
    use HasFactory;
    protected $guarded=[];

    public function assignments(){
        return $this->hasMany(Assignment::class);
    }
    public function group(){
        return $this->hasOne(Group::class);
    }
}
