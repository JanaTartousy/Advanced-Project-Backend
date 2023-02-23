<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KPI extends Model
{

    use HasFactory;
    protected $fillable = [
        "name",
        "description"
    ];
    public function evaluation(){
        return $this -> hasMany(evaluations::class);
    }
    // public function projects(){
    //     return $this -> belongsToMany(Project::class);
    // }

}