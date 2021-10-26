<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;

class Intern extends Model
{
    use HasApiTokens,HasFactory;
    protected $guarded=[];

    public function assignments(){
        return $this->hasMany(Assignment::class);
    }
    public function group(){
        return $this->hasOne(Group::class);
    }
}
