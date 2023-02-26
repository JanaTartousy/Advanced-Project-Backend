<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;

    protected $fillable = ['first_name', 'last_name', 'email', 'dob', 'phone_number', 'picture', 'team_id'];


    public function team()
    {
        return $this->belongsTo(Team::class);
    }

    public function employeeRole()
    {
        return $this->belongsTo(EmployeeRole::class, 'id', 'employee_id');
    }
}
