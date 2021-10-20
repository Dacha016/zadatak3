<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mentor extends Model
{
    use HasFactory;
    protected $table = "mentors";

    protected $guarded=[];

    public function interns(){
        return $this->hasMany(Intern::class);
    }
    public function group(){
        return $this->hasOne(Group::class);
    }
}
