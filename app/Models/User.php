<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable
{
    // use HasApiTokens, HasFactory, Notifiable, SoftDeletes;
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guarded = ['id'];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    public function roleId(){
        return $this->belongsTo('App\Models\Role','role_id','id');
    }
    public function createdby(){
        return $this->hasOne('App\Models\User', 'id', 'created_by')->select('id','name','email');
    }
    public function deletedBy(){
        return $this->hasOne('App\Models\User', 'id', 'deleted_by')->select('id','name','email');
    }
    public function updatedby(){
        return $this->hasOne('App\Models\User', 'id', 'updated_by')->select('id','name','email');
    }
}
