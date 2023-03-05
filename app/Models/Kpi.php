<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kpi extends Model
{
// the content of table : Kpis , in database.

    use HasFactory;
    protected $fillable = [
        "name",
        "description"
    ];
    // Relation between the tables : Evaluation and Kpis.

    public function evaluation(){
        return $this -> hasMany(Evaluation::class);
    }
    // public function projects(){
    //     return $this -> belongsToMany(Project::class);
    // }

}
