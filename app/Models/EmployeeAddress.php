<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmployeeAddress extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    public function employeeId(){
        return $this->belongsTo('App\Models\Employee','employee_id','id');
    }
    public function localCountryId(){
        return $this->belongsTo('App\Models\Country','local_country_id','id')->withTrashed();
    }
    public function localCityId(){
        return $this->belongsTo('App\Models\City','local_city_id','id')->withTrashed();
    }
    public function homeCountryId(){
        return $this->belongsTo('App\Models\Country','home_country_id','id')->withTrashed();
    }
    public function homeCityId(){
        return $this->belongsTo('App\Models\City','home_city_id','id')->withTrashed();
    }
    public function createdBy(){
        return $this->belongsTo('App\Models\User','created_by','id')->select('id','name','email');
    }
    public function updatedBy(){
        return $this->belongsTo('App\Models\User','updated_by','id')->select('id','name','email');
    }
}
