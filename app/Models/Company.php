<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Company extends Model
{
    use HasFactory, SoftDeletes;
    protected $guarded = ['id'];

    public static function boot() {
        
        parent::boot();

        static::deleting(function($company) {
             $company->companyBank()->delete();
             $company->companyBranch()->delete();
             $company->companyDepartment()->delete();
             $company->companyNote()->delete();
             $company->companySchedule()->delete();
             $company->companyDepartmentSection()->delete();
             $company->companyEffectivityPreference()->delete();
             $company->companyEmployee()->delete();
        });
    }

    public function companyBank(){
        return $this->hasMany('App\Models\CompanyBank');
    }
    public function companyBranch(){
        return $this->hasMany('App\Models\CompanyBranch');
    }
    public function companyDepartment(){
        return $this->hasMany('App\Models\CompanyDepartment');
    }
    public function companyNote(){
        return $this->hasMany('App\Models\CompanyNote');
    }
    public function companySchedule(){
        return $this->hasMany('App\Models\CompanySchedule');
    }
    public function companyDepartmentSection(){
        return $this->hasMany('App\Models\CompanyDepartmentSection');
    }
    public function companyEffectivityPreference(){
        return $this->hasMany('App\Models\CompanyEffectivityPreference');
    }
    public function companyEmployee(){
        return $this->hasMany('App\Models\CompanyEmployee');
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
