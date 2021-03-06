<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Intern extends Model
{
    use HasFactory;
    protected $guarded=[];
    public function group(){
        return $this->belongsTo(Group::class);
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
