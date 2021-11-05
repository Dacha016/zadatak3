<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Intern extends Model
{
    use HasFactory;
    public function group(){
        return $this->hasOne(Group::class);
    }
    public function role(){
        return $this->belongsTo(Role::class);
    }
    public function mentors(){
        return $this->belongsToMany(Mentor::class);
    }
    public function assignments(){
        return $this->belongsToMany(Assignment::class);
    }
}
