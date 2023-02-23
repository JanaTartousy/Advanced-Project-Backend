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

    public function employeeRoles()
    {
        return $this->hasMany(EmployeeRole::class);
    }

    public function employees()
    {
        return $this->belongsToMany(Employee::class, 'employee_role')->withPivot('role_id');
    }

    public function roles()
    {
        return $this->belongsToMany(Role::class, 'employee_role')->withPivot('employee_id');
    }
}
