<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;
// The content of table : Employees, in databse .

    protected $fillable = ['first_name', 'last_name', 'email', 'dob', 'phone_number', 'picture', 'team_id'];

// Relation between the tables : Employees and Teams

    public function team()
    {
        return $this->belongsTo(Team::class);
    }
// Relation between the tables : Employees and EmployeeRole.

    public function employeeRole()
    {
        return $this->belongsTo(EmployeeRole::class, 'id', 'employee_id');
    }
    // Relation between the tables : Employees and Evaluation .

    public function evaluations(){
        return $this -> hasMany(Evaluation::class);
    }
}
