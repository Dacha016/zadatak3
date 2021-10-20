<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    use HasFactory;
    protected $guarded=[];
    public function mentors(){
        return $this->hasMany(Mentor::class);
    }
    public function interns(){
        return $this->hasMany(Intern::class);
    }
    public function assignments(){
        return $this->hasMany(Assignment::class);
    }
}
