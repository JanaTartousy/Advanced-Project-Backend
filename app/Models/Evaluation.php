<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Evaluation extends Model
{
    use HasFactory;

    protected $fillable = ['date_evaluated', 'evaluation'];
    public function employees()
    {
        return $this->hasOne(Employee::class);
    }
    public function kpis()
    {
        return $this->hasOne(KPI::class);
    }
}
