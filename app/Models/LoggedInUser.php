<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Sanctum\HasApiTokens;
class LoggedInUser extends Authenticatable

{
    use  HasApiTokens,HasFactory;
    protected $guarded=[];

    public function role(){
        return $this->belongsToMany(Role::class);
    }
}
