<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EvaluationPost extends Model
{
    use HasFactory;
    protected $guarded = ['id'];
    public function companyId(){
        return $this->belongsTo('App\Models\Company','company_id','id');
    }
    public function designationId(){
        return $this->belongsTo('App\Models\Designation','designation_id','id');
    }
    public function branchId(){
        return $this->belongsTo('App\Models\CompanyBranch','branch_id','id');
    }
    public function evaluationId(){
        return $this->belongsTo('App\Models\EvaluationType','evaluation_id','id');
    }
    public function createdBy(){
        return $this->belongsTo('App\Models\User','created_by','id')->select('id','name','email');
    }
    public function updatedBy(){
        return $this->belongsTo('App\Models\User','updated_by','id')->select('id','name','email');
    }
}
