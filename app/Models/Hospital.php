<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use App\Scopes\HospitalScope;

/**
 * Class Hospital
 * @package App\Models
 * @version August 30, 2020, 5:38 pm UTC
 *
 * @property \Illuminate\Database\Eloquent\Collection $branches
 * @property \Illuminate\Database\Eloquent\Collection $documentcodeHospitals
 * @property \Illuminate\Database\Eloquent\Collection $moduleHospitals
 * @property \Illuminate\Database\Eloquent\Collection $moduleUsergroups
 * @property \Illuminate\Database\Eloquent\Collection $modules
 * @property \Illuminate\Database\Eloquent\Collection $patients
 * @property \Illuminate\Database\Eloquent\Collection $userHospitals
 * @property \Illuminate\Database\Eloquent\Collection $userUsergroups
 * @property \Illuminate\Database\Eloquent\Collection $usergroups
 * @property \Illuminate\Database\Eloquent\Collection $users
 * @property string $name
 * @property string $short_code
 * @property string $logo
 */
class Hospital extends Model
{
    //use SoftDeletes;

    public $table = 'hospitals';
    
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';


    protected $dates = ['deleted_at'];



    public $fillable = [
        'name',
        'short_code',
        'logo'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'name' => 'string',
        'short_code' => 'string',
        'logo' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'name' => 'required|string|max:255',
        'short_code' => 'required|string|max:255',
        'logo' => 'required|string',
        'created_at' => 'nullable',
        'updated_at' => 'nullable'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     **/
    public function branches()
    {
        return $this->hasMany(\App\Models\Branch::class, 'hospital_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     **/
    public function documentcodeHospitals()
    {
        return $this->hasMany(\App\Models\DocumentcodeHospital::class, 'hospital_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     **/
    public function moduleHospitals()
    {
        return $this->hasMany(\App\Models\ModuleHospital::class, 'hospital_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     **/
    public function moduleUsergroups()
    {
        return $this->hasMany(\App\Models\ModuleUsergroup::class, 'hospital_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     **/
    public function modules()
    {
        return $this->belongsToMany(\App\Models\Module::class, 'module_hospital', 'hospital_id', 'module_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     **/
    public function patients()
    {
        return $this->hasMany(\App\Models\Patient::class, 'hospital_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     **/
    public function userHospitals()
    {
        return $this->hasMany(\App\Models\UserHospital::class, 'hospital_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     **/
    public function userUsergroups()
    {
        return $this->hasMany(\App\Models\UserUsergroup::class, 'hospital_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     **/
    public function usergroups()
    {
        return $this->hasMany(\App\Models\Usergroup::class, 'hospital_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     **/
    public function users()
    {
        return $this->belongsToMany(\App\Models\User::class, 'user_hospital' , 'hospital_id' , 'user_id');
    }
}
