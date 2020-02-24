<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Leave extends Model
{
    protected $fillable = ['leaveType_name','emp_id', 'date_start','date_end','numday','status','descr','approves_id'];
}
