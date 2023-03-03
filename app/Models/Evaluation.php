<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Evaluation extends Model
{
    use HasFactory;

// the content of table Evaluation , in database.

    protected $fillable = ['date_evaluated', 'evaluation','employee_id','kpi_id'];

    // Relation between the tables : Evaluation and employees.

    public function employees()
    {
        return $this->belongsTo(Employee::class,"employee_id");
    }

    // Relation between the tables : Evaluation and Kpis.
    
    public function kpis()
    {
        return $this->belongsTo(Kpi::class,'kpi_id');
    }
    
}