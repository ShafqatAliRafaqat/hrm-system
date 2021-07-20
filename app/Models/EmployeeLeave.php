<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmployeeLeave extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    public function employeeId(){
        return $this->belongsTo('App\Models\Employee','employee_id','id');
    }
    public function leaveId(){
        return $this->belongsTo('App\Models\Leave','leave_id','id');
    }
    public function createdBy(){
        return $this->belongsTo('App\Models\User','created_by','id')->select('id','name','email');
    }
    public function updatedBy(){
        return $this->belongsTo('App\Models\User','updated_by','id')->select('id','name','email');
    }
}
