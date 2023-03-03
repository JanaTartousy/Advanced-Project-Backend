<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;
// The content of table : roles, in databse.

    protected $fillable = [
        "name"
    ];
// Relation between the tables : roles and employees.

    public function employees()
    {
        return $this->belongsToMany(Employee::class, 'employee_role');
    }
// Relation between the tables : projects and roles.

    public function projects()
    {
        return $this->belongsToMany(Project::class, 'employee_role')->withPivot('employee_id');
    }
}



