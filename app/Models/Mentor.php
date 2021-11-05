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


    public function groups(){
        return $this->belongsToMany(Group::class);
    }
    public function role(){
        return $this->belongsTo(Role::class);
    }
}
