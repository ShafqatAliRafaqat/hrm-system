<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Country extends Model
{
    use HasFactory, SoftDeletes;
    // protected $guarded = ['id'];
    protected $fillable = ['en_name','ar_name','en_nationality','ar_nationality','code','phonecode'];
    
    protected $primaryKey = 'id';
    public function city(){
        return $this->hasMany('App\Models\City');
    }
}
