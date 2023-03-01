<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Employee extends Authenticatable implements JWTSubject
{
    use HasFactory,Notifiable;

    protected $fillable = ['first_name', 'last_name', 'email', 'dob', 'phone_number', 'picture', 'team_id'];


    public function team()
    {
        return $this->belongsTo(Team::class);
    }

    public function employeeRole()
    {
        return $this->belongsTo(EmployeeRole::class, 'id', 'employee_id');
    }
    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }
}
