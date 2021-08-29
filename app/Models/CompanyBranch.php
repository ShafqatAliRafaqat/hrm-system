<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CompanyBranch extends Model
{
    use HasFactory, SoftDeletes;
    protected $guarded = ['id'];
    
    public static function boot() {
        
        parent::boot();

        static::deleting(function($company) {
             $company->benefitPost()->delete();
             $company->companyDepartment()->delete();
             $company->effenctivityPreference()->delete();
             $company->employee()->delete();
             $company->employment()->delete();
             $company->evaluationPost()->delete();
             $company->gosiPreference()->delete();
             $company->leaveSpecificPreference()->delete();
             $company->legalDocument()->delete();
             $company->letter()->delete();
             $company->payrollPreference()->delete();
             $company->SMSTemplate()->delete();
             $company->terminationSpecificPreference()->delete();
        });
    }

    public function benefitPost(){
        return $this->hasMany('App\Models\BenefitPost');
    }
    public function companyDepartment(){
        return $this->hasMany('App\Models\CompanyDepartment');
    }
    public function effenctivityPreference(){
        return $this->hasMany('App\Models\EffenctivityPreference');
    }
    public function employee(){
        return $this->hasMany('App\Models\Employee');
    }
    public function employment(){
        return $this->hasMany('App\Models\Employment');
    }
    public function evaluationPost(){
        return $this->hasMany('App\Models\EvaluationPost');
    }
    public function gosiPreference(){
        return $this->hasMany('App\Models\GosiPreference');
    }
    public function leaveSpecificPreference(){
        return $this->hasMany('App\Models\LeaveSpecificPreference');
    }
    public function legalDocument(){
        return $this->hasMany('App\Models\LegalDocument');
    }
    public function letter(){
        return $this->hasMany('App\Models\Letter');
    }
    public function payrollPreference(){
        return $this->hasMany('App\Models\PayrollPreference');
    }
    public function SMSTemplate(){
        return $this->hasMany('App\Models\SMSTemplate');
    }
    public function terminationSpecificPreference(){
        return $this->hasMany('App\Models\TerminationSpecificPreference');
    }
    public function companyId(){
        return $this->belongsTo('App\Models\Company','company_id','id');
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
