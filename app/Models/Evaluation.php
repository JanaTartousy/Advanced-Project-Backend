<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Evaluation extends Model
{
    use HasFactory;


    protected $fillable = ['date_evaluated', 'evaluation','employee_id','kpi_id'];
    public function employees()
    {
        return $this->belongsTo(Employee::class,"employee_id");
    }
    public function kpis()
    {
        return $this->belongsTo(Kpi::class,'kpi_id');
    }
    
}