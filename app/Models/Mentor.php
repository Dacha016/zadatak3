<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;

class Mentor extends Model
{
    use  HasApiTokens;
    protected $table = "mentors";

    protected $guarded=[];

    public function interns(){
        return $this->hasMany(Intern::class);
    }
    public function group(){
        return $this->hasMany(Group::class);
    }
    public function role(){
        return $this->belongsTo(Role::class);
    }
}
