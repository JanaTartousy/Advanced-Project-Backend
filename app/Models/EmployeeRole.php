<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmployeeRole extends Model
{
    use HasFactory;
    // The content of table : projects_employee_role, in databse.

    protected $fillable =[
        "employee_id","project_id","role_id",
    ];
    // Relation between this table and table of teams .

    public function team(){
        return $this ->belongsTo(Team::class);
    }
// Relation between this table and table of employees .

    public function employees()
    {
        return $this->hasMany(Employee::class);
    }
    // Relation between this table and table of projects .

    public function projects()
    {
        return $this->belongsTo(Project::class);
    }
    // Relation between this table and table of roles.

    public function role()
    {
        return $this->belongsTo(Role::class);
    }
}
