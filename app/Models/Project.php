<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;

    protected $fillable = [
        "name",
        "description",
        "finished",
        "team_id"
    ];

    protected $casts = [
        'finished' => 'boolean',
    ];

    public function team()
    {
        return $this->belongsTo(Team::class);
    }

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
