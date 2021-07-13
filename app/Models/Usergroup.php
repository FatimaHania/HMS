<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use App\Scopes\HospitalScope;

/**
 * Class Usergroup
 * @package App\Models
 * @version December 3, 2020, 6:17 pm UTC
 *
 * @property \App\Models\Branch $branch
 * @property \App\Models\Hospital $hospital
 * @property \Illuminate\Database\Eloquent\Collection $moduleUsergroups
 * @property \Illuminate\Database\Eloquent\Collection $userUsergroups
 * @property string $description
 * @property integer $hospital_id
 * @property integer $branch_id
 */
class Usergroup extends Model
{
    use SoftDeletes;

    public $table = 'usergroups';
    
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';


    protected $dates = ['deleted_at'];



    public $fillable = [
        'description',
        'hospital_id',
        'branch_id'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'description' => 'string',
        'hospital_id' => 'integer',
        'branch_id' => 'integer'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'description' => 'required|string|max:255',
        'created_at' => 'nullable',
        'updated_at' => 'nullable',
        'hospital_id' => 'nullable',
        'branch_id' => 'nullable',
        'deleted_at' => 'nullable'
    ];

    protected static function booted()
    {
        static::addGlobalScope(new HospitalScope);
    }


    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function branch()
    {
        return $this->belongsTo(\App\Models\Branch::class, 'branch_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function hospital()
    {
        return $this->belongsTo(\App\Models\Hospital::class, 'hospital_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\belongsToMany
     **/
    public function modules()
    {
        return $this->belongsToMany(\App\Models\Module::class, 'module_usergroup' , 'usergroup_id' , 'module_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     **/
    public function moduleUsergroups()
    {
        return $this->hasMany(\App\Models\ModuleUsergroup::class, 'usergroup_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     **/
    public function userUsergroups()
    {
        return $this->hasMany(\App\Models\UserUsergroup::class, 'usergroup_id');
    }
}
