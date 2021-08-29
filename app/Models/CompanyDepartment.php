<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CompanyDepartment extends Model
{
    use HasFactory, SoftDeletes;
    protected $guarded = ['id'];

    public static function boot() {
        
        parent::boot();

        static::deleting(function($company) {
             $company->departmentSection()->delete();
             $company->employee()->delete();
             $company->legalDocument()->delete();
        });
    }
    public function departmentSection(){
        return $this->hasMany('App\Models\DepartmentSection');
    }
    public function employee(){
        return $this->hasMany('App\Models\Employee');
    }
    public function legalDocument(){
        return $this->hasMany('App\Models\LegalDocument');
    }
    public function companyId(){
        return $this->belongsTo('App\Models\Company','company_id','id');
    }
    public function branchId(){
        return $this->belongsTo('App\Models\CompanyBranch','branch_id','id');
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
