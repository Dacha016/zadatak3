<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $guarded=[];
    protected $table = "users";

    public function interns(){
        return $this->hasMany(Intern::class);
    }
    public function mentors(){
        return $this->hasMany(Mentor::class);
    }
    public function admins(){
        return $this->hasMany(Admin::class);
    }
    public function recruiters(){
        return $this->hasMany(Recruiter::class);
    }
}
