<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;

    protected $fillable = ['first_name', 'last_name', 'email', 'dob', 'phone_number', 'picture'];

    public function team()
    {
        return $this->belongsTo(Team::class);
    }

    public function evaluation()
    {
        return $this->belongsTo(Evaluation::class);
    }

    public function roles()
    {
        return $this->belongsToMany(Role::class, 'employee_role');
    }

    public function projects()
    {
        return $this->belongsToMany(Project::class, 'employee_role')->withPivot('role_id');
    }
}


