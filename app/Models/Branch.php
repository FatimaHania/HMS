<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Branch
 * @package App\Models
 * @version August 30, 2020, 5:52 pm UTC
 *
 * @property \App\Models\Hospital $hospital
 * @property \App\Models\Country $country
 * @property \Illuminate\Database\Eloquent\Collection $documentcodeHospitals
 * @property \Illuminate\Database\Eloquent\Collection $moduleHospitals
 * @property \Illuminate\Database\Eloquent\Collection $moduleUsergroups
 * @property \Illuminate\Database\Eloquent\Collection $modules
 * @property \Illuminate\Database\Eloquent\Collection $patients
 * @property \Illuminate\Database\Eloquent\Collection $userHospitals
 * @property \Illuminate\Database\Eloquent\Collection $userUsergroups
 * @property \Illuminate\Database\Eloquent\Collection $usergroups
 * @property \Illuminate\Database\Eloquent\Collection $users
 * @property integer $hospital_id
 * @property string $name
 * @property string $short_code
 * @property string $telephone_1
 * @property string $telephone_2
 * @property string $telephone_3
 * @property string $address
 */
class Branch extends Model
{
    //use SoftDeletes;

    public $table = 'branches';
    
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';


    protected $dates = ['deleted_at'];



    public $fillable = [
        'hospital_id',
        'name',
        'short_code',
        'telephone_1',
        'telephone_2',
        'telephone_3',
        'address',
        'country_id',
        'default_currency_id',
        'reporting_currency_id'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'hospital_id' => 'integer',
        'name' => 'string',
        'short_code' => 'string',
        'telephone_1' => 'string',
        'telephone_2' => 'string',
        'telephone_3' => 'string',
        'address' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'hospital_id' => 'nullable',
        'name' => 'required|string|max:255',
        'short_code' => 'required|string|max:255',
        'telephone_1' => 'required|string',
        'telephone_2' => 'string',
        'telephone_3' => 'string',
        'address' => 'required|string',
        'created_at' => 'nullable',
        'updated_at' => 'nullable'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function hospital()
    {
        return $this->belongsTo(\App\Models\Hospital::class, 'hospital_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function country()
    {
        return $this->belongsTo(\App\Models\Country::class, 'country_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function default_currency()
    {
        return $this->belongsTo(\App\Models\Currency::class, 'default_currency_id');
    }


    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function reporting_currency()
    {
        return $this->belongsTo(\App\Models\Currency::class, 'reporting_currency_id');
    }

    
    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     **/
    public function documentcodeHospitals()
    {
        return $this->hasMany(\App\Models\DocumentcodeHospital::class, 'branch_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     **/
    public function moduleHospitals()
    {
        return $this->hasMany(\App\Models\ModuleHospital::class, 'branch_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     **/
    public function moduleUsergroups()
    {
        return $this->hasMany(\App\Models\ModuleUsergroup::class, 'branch_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     **/
    public function modules()
    {
        return $this->hasMany(\App\Models\Module::class, 'branch_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     **/
    public function patients()
    {
        return $this->hasMany(\App\Models\Patient::class, 'branch_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     **/
    public function userHospitals()
    {
        return $this->hasMany(\App\Models\UserHospital::class, 'branch_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     **/
    public function userUsergroups()
    {
        return $this->hasMany(\App\Models\UserUsergroup::class, 'branch_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     **/
    public function usergroups()
    {
        return $this->hasMany(\App\Models\Usergroup::class, 'branch_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     **/
    public function users()
    {
        return $this->hasMany(\App\Models\User::class, 'branch_id');
    }
}
