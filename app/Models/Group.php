<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
   
    protected $guarded=[];
    public function mentor(){
        return $this->belongsTo(Mentor::class);
    }
    public function intern(){
        return $this->belongsTo(Intern::class);
    }
    public function assignment(){
        return $this->belongsTo(Assignment::class);
    }
}
