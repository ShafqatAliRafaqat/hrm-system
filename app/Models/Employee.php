<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Employee extends Model
{
    use HasFactory ,SoftDeletes;
    protected $guarded = ['id'];

    public static function boot() {
        
        parent::boot();

        static::deleting(function($company) {
             $company->employeeAddree()->delete();
             $company->employeeDeducation()->delete();
             $company->employeeDependent()->delete();
             $company->employeeDocment()->delete();
             $company->employeeDocmentPath()->delete();
             $company->employeeEarning()->delete();
             $company->employeeEvaluation()->delete();
             $company->employeeEvaluationResult()->delete();
             $company->employeeExperience()->delete();
             $company->employeeLeave()->delete();
             $company->employeeModification()->delete();
             $company->employeeNote()->delete();
             $company->employeeTraining()->delete();
             $company->employeeExperience()->delete();
             $company->employeeEmployment()->delete();
        });
    }
    public function employeeAddree(){
        return $this->hasMany('App\Models\EmployeeAddree');
    }
    public function employeeDeducation(){
        return $this->hasMany('App\Models\EmployeeDeducation');
    }
    public function employeeDependent(){
        return $this->hasMany('App\Models\EmployeeDependent');
    }
    public function employeeDocment(){
        return $this->hasMany('App\Models\EmployeeDocment');
    }
    public function employeeDocmentPath(){
        return $this->hasMany('App\Models\EmployeeDocmentPath');
    }
    public function employeeEarning(){
        return $this->hasMany('App\Models\EmployeeEarning');
    }
    public function employeeEvaluation(){
        return $this->hasMany('App\Models\EmployeeEvaluation');
    }
    public function employeeEvaluationResult(){
        return $this->hasMany('App\Models\EmployeeEvaluationResult');
    }
    public function employeeExperience(){
        return $this->hasMany('App\Models\EmployeeExperience');
    }
    public function employeeLeave(){
        return $this->hasMany('App\Models\EmployeeLeave');
    }
    public function employeeModification(){
        return $this->hasMany('App\Models\EmployeeModification');
    }
    public function employeeNote(){
        return $this->hasMany('App\Models\EmployeeNote');
    }
    public function employeeTraining(){
        return $this->hasMany('App\Models\EmployeeTraining');
    }
    public function employeeEmployment(){
        return $this->hasMany('App\Models\Employment');
    }
    public function companyId(){
        return $this->belongsTo('App\Models\Company','company_id','id');
    }
    public function branchId(){
        return $this->belongsTo('App\Models\CompanyBranch','branch_id','id');
    }
    public function positionId(){
        return $this->belongsTo('App\Models\Designation','position_id','id');
    }
    public function religionId(){
        return $this->belongsTo('App\Models\Religion','religion_id','id');
    }
    public function departmentId(){
        return $this->belongsTo('App\Models\CompanyDepartment','department_id','id');
    }
    public function costCenterId(){
        return $this->belongsTo('App\Models\CostCenter','cost_center_id','id');
    }
    public function countryId(){
        return $this->belongsTo('App\Models\Country','country_id','id')->withTrashed();
    }
    public function cityId(){
        return $this->belongsTo('App\Models\City','city_id','id')->withTrashed();
    }
    public function createdBy(){
        return $this->belongsTo('App\Models\User','created_by','id')->select('id','name','email');
    }
    public function updatedBy(){
        return $this->belongsTo('App\Models\User','updated_by','id')->select('id','name','email');
    }
    public function deletedBy(){
        return $this->belongsTo('App\Models\User','deleted_by','id')->select('id','name','email');
    }
}
