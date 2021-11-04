<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;

class Recruiter extends Model
{
    use HasApiTokens;
    protected $guarded=[];
    public function role(){
        return $this->belongsTo(Role::class);
    }
}
