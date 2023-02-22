<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;
    public function team()
    {
        return $this->belongsTo(Team::class);
    }
    public function employees(){
        return $this -> belongsToMany(Employee::class);
    }
    public function role(){
        return $this -> belongsToMany(Role::class);
    }
}
