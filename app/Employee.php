<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    protected $fillable = ['username', 'password','role_name','dept_name','AL','MC'];
}
