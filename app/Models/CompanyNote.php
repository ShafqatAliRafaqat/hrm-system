<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CompanyNote extends Model
{
    use HasFactory;
    protected $guarded = ['id'];
    public function companyId(){
        return $this->belongsTo('App\Models\Company','company_id','id');
    }
}
