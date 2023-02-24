<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;

    protected $fillable = [
        "name"
    ];

    public function employees()
    {
        return $this->belongsToMany(Employee::class, 'employee_role');
    }

    public function projects()
    {
        return $this->belongsToMany(Project::class, 'employee_role')->withPivot('employee_id');
    }
}



