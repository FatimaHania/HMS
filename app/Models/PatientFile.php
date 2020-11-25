<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use Carbon\Carbon;
use App\Scopes\HospitalScope;

/**
 * Class PatientFile
 * @package App\Models
 * @version October 15, 2020, 6:08 pm UTC
 *
 * @property \App\Models\Branch $branch
 * @property \App\Models\Department $department
 * @property \App\Models\Disease $disease
 * @property \App\Models\Hospital $hospital
 * @property \App\Models\Patient $patient
 * @property string $file_name
 * @property string $description
 * @property integer $patient_id
 * @property integer $department_id
 * @property integer $disease_id
 * @property boolean $is_active
 * @property integer $hospital_id
 * @property integer $branch_id
 */
class PatientFile extends Model
{
    use SoftDeletes;

    public $table = 'patient_files';
    
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';


    protected $dates = ['deleted_at'];



    public $fillable = [
        'file_name',
        'description',
        'patient_id',
        'department_id',
        'disease_id',
        'is_active',
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
        'file_name' => 'string',
        'description' => 'string',
        'patient_id' => 'integer',
        'department_id' => 'integer',
        'disease_id' => 'integer',
        'is_active' => 'boolean',
        'hospital_id' => 'integer',
        'branch_id' => 'integer'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'file_name' => 'nullable|string|max:255',
        'description' => 'nullable|string',
        'patient_id' => 'required',
        'department_id' => 'required',
        'disease_id' => 'required',
        'is_active' => 'required|boolean',
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
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function branch()
    {
        return $this->belongsTo(\App\Models\Branch::class, 'branch_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function department()
    {
        return $this->belongsTo(\App\Models\Department::class, 'department_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function disease()
    {
        return $this->belongsTo(\App\Models\Disease::class, 'disease_id');
    }

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
    public function patient()
    {
        return $this->belongsTo(\App\Models\Patient::class, 'patient_id');
    }
}
