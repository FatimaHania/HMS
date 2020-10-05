<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use App\Scopes\HospitalScope;

/**
 * Class DepartmentRoom
 * @package App\Models
 * @version October 3, 2020, 3:42 pm UTC
 *
 * @property \Illuminate\Database\Eloquent\Collection $departmentRooms
 * @property string $short_code
 * @property string $description
 * @property integer $hospital_id
 * @property integer $branch_id
 */
class DepartmentRoom extends Model
{
    use SoftDeletes;

    public $table = 'departments';
    
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';


    protected $dates = ['deleted_at'];



    public $fillable = [
        'short_code',
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
        'short_code' => 'string',
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
        'short_code' => 'required|string|max:255',
        'description' => 'required|string|max:255',
        'hospital_id' => 'required',
        'branch_id' => 'required',
        'created_at' => 'nullable',
        'updated_at' => 'nullable',
        'deleted_at' => 'nullable'
    ];

    protected static function booted()
    {
        static::addGlobalScope(new HospitalScope);
    }


    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     **/
    public function departmentRooms()
    {
        return $this->hasMany(\App\Models\DepartmentRoom::class, 'department_id');
    }
}
