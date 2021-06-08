<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CompanyBank extends Model
{
    use HasFactory, SoftDeletes;
    protected $guarded = ['id'];
    public function companyId(){
        return $this->belongsTo('App\Models\Company','company_id','id');
    }
    public function countryId(){
        return $this->belongsTo('App\Models\Country','country_id','id');
    }
    public function cityId(){
        return $this->belongsTo('App\Models\City','city_id','id');
    }
    public function branchId(){
        return $this->belongsTo('App\Models\CompanyBranch','branch_id','id');
    }
    public function currencyId(){
        return $this->belongsTo('App\Models\CurrencyType','currency_id','id');
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
