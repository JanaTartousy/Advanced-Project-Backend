<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    use HasFactory;
// The content of table : teams , in databse.

    protected $fillable = [
        "name"
    ];
// Relation between the tables : employess and teams.

    public function employees()
    {
        return $this->hasMany(Employee::class);
    }
// Relation between the tables : teams and projects.

    public function projects()
    {
        return $this->hasMany(Project::class);
    }
}

