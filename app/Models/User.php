<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;


/**
 * Class User
 * @package App\Models
 * @version December 3, 2020, 5:35 pm UTC
 *
 * @property \App\Models\Branch $branch
 * @property \App\Models\Hospital $hospital
 * @property \App\Models\Usertype $usertype
 * @property \Illuminate\Database\Eloquent\Collection $sessions
 * @property \Illuminate\Database\Eloquent\Collection $session1s
 * @property \Illuminate\Database\Eloquent\Collection $session2s
 * @property \Illuminate\Database\Eloquent\Collection $userHospitals
 * @property \Illuminate\Database\Eloquent\Collection $userUsergroups
 * @property string $name
 * @property string $email
 * @property string|\Carbon\Carbon $email_verified_at
 * @property string $password
 * @property string $remember_token
 * @property integer $hospital_id
 * @property integer $branch_id
 * @property integer $usertype_id
 */
class User extends Model
{
    use SoftDeletes;

    public $table = 'users';
    
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';


    protected $dates = ['deleted_at'];



    public $fillable = [
        'name',
        'email',
        'email_verified_at',
        'password',
        'remember_token',
        'hospital_id',
        'branch_id',
        'usertype_id'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'name' => 'string',
        'email' => 'string',
        'email_verified_at' => 'datetime',
        'password' => 'string',
        'remember_token' => 'string',
        'hospital_id' => 'integer',
        'branch_id' => 'integer',
        'usertype_id' => 'integer'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'name' => 'required|string|max:255',
        'email' => 'required|string|max:255',
        'email_verified_at' => 'nullable',
        'password' => 'required|string|max:255',
        'remember_token' => 'nullable|string|max:100',
        'created_at' => 'nullable',
        'updated_at' => 'nullable',
        'hospital_id' => 'nullable',
        'branch_id' => 'nullable',
        'usertype_id' => 'nullable'
    ];



    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     **/
    public function branches()
    {
        return $this->belongsToMany(\App\Models\Branch::class, 'user_hospital' , 'user_id' , 'branch_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     **/
    public function hospitals()
    {
        return $this->belongsToMany(\App\Models\Hospital::class, 'user_hospital', 'user_id', 'hospital_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function usertype()
    {
        return $this->belongsTo(\App\Models\Usertype::class, 'usertype_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     **/
    public function sessions()
    {
        return $this->hasMany(\App\Models\Session::class, 'cancelled_by');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     **/
    public function session1s()
    {
        return $this->hasMany(\App\Models\Session::class, 'completed_by');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     **/
    public function session2s()
    {
        return $this->hasMany(\App\Models\Session::class, 'started_by');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     **/
    public function userHospitals()
    {
        return $this->hasMany(\App\Models\UserHospital::class, 'user_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\belongsToMany
     **/
    public function usergroups()
    {
        return $this->belongsToMany(\App\Models\Usergroup::class, 'user_usergroup' , 'user_id' , 'usergroup_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     **/
    public function userUsergroups()
    {
        return $this->hasMany(\App\Models\UserUsergroup::class, 'user_id');
    }
}
