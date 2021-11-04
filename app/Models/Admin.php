<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Foundation\Auth\User as Authenticatable;


class Admin extends Model
{
    use HasApiTokens, HasFactory;
    protected $guarded=[];
    public function role(){
        return $this->belongsTo(Role::class);
    }
}
