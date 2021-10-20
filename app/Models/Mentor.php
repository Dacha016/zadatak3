<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mentor extends Model
{
    use HasFactory;

    protected $guarded=[];

    public function interns(){
        return $this->hasMany(Intern::class);
    }
    public function groups(){
        return $this->hasOne(Group::class);
    }
}
