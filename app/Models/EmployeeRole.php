<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmployeeRole extends Model
{
    use HasFactory;
    protected $fillable =[
        "employee_id","project_id","role_id",
    ];
    public function team(){
        return $this ->belongsTo(Team::class);
    }

    public function employees()
    {
        return $this->hasMany(Employee::class);
    }
    public function projects()
    {
        return $this->belongsTo(Project::class);
    }
    public function role()
    {
        return $this->belongsTo(Role::class);
    }
}
