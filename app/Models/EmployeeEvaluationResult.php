<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmployeeEvaluationResult extends Model
{
    use HasFactory;
    protected $guarded = ['id'];
    protected $cast = ['evaluation_ids'=> 'json'];

    public function companyId(){
        return $this->belongsTo('App\Models\Company','company_id','id');
    }
    public function branchId(){
        return $this->belongsTo('App\Models\CompanyBranch','branch_id','id');
    }
    public function employeeId(){
        return $this->belongsTo('App\Models\Employee','employee_id','id');
    }
    public function employeeEvaluationId(){
        return $this->belongsTo('App\Models\EmployeeEvaluation','employee_evaluation_id','id');
    }
    public function evaluationTypeId(){
        return $this->belongsTo('App\Models\EvaluationType','evaluation_type_id','id');
    }
    public function createdBy(){
        return $this->belongsTo('App\Models\User','created_by','id')->select('id','name','email');
    }
    public function updatedBy(){
        return $this->belongsTo('App\Models\User','updated_by','id')->select('id','name','email');
    }
}
