<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    use HasFactory;
    public function employee()
    {
        return $this->hasMany(Employee::class);
    }
    public function project()
    {
        return $this->hasMany(Project::class);
    }
}
