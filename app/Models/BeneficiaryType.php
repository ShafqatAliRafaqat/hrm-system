<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BeneficiaryType extends Model
{
    use HasFactory, SoftDeletes;
    protected $guarded = ['id'];

    public static function boot() {
        
        parent::boot();

        static::deleting(function($company) {
             $company->benefitPost()->delete();
             $company->employeeEarning()->delete();
        });
    }
    public function benefitPost(){
        return $this->hasMany('App\Models\BenefitPost');
    }
    public function employeeEarning(){
        return $this->hasMany('App\Models\EmployeeEarning');
    }
}
