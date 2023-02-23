<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Evaluation extends Model
{
    use HasFactory;
    
    protected $fillable =[
        "date_evaluated",
        "evaluation"
    ];

    public function employeeKpi ()
    {
        return $this->belongsTo(EmployeeKpi::class);
    }
}
