<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;
// The content of table : projects , in database.

    protected $fillable = [
        "name",
        "description",
        "finished",
        "team_id"
    ];

    protected $casts = [
        'finished' => 'boolean',
    ];
// Relation between the tables : teams and projects.

    public function team()
    {
        return $this->belongsTo(Team::class);
    }
// Relation between the tables :projects and projects_employee_role.

    public function employeeRole()
    {
        return $this->belongsTo(EmployeeRole::class);
    }
    public function getEmployeesWithRoles()
{
    return $this->hasManyThrough(
        Employee::class,
        Team::class,
        'project_id', // Foreign key on teams table...
        'team_id', // Foreign key on employees table...
        'id', // Local key on projects table...
        'id' // Local key on teams table...
    )->with('employeeRole.role:id,fist_name,last_name');
}

}
