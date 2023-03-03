<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Admin extends Model
{
    use HasFactory;
// The content of table : Admins , in databse.

    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'password',
    ];
    // protected $hidden = [
    //     'password',
    // ];
}
