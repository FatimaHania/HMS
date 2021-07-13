<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use App\Scopes\HospitalScope;

/**
 * Class Laboratory
 * @package App\Models
 * @version January 16, 2021, 5:46 pm UTC
 *
 * @property \App\Models\Branch $branch
 * @property \App\Models\Hospital $hospital
 * @property integer $lab_number
 * @property string $lab_code
 * @property string $name
 * @property string $short_code
 * @property string $address
 * @property string $telephone_1
 * @property string $telephone_2
 * @property string $email
 * @property boolean $is_active
 * @property integer $hospital_id
 * @property integer $branch_id
 */
class Laboratory extends Model
{
    use SoftDeletes;

    public $table = 'laboratories';
    
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';


    protected $dates = ['deleted_at'];



    public $fillable = [
        'lab_number',
        'lab_code',
        'name',
        'short_code',
        'address',
        'telephone_1',
        'telephone_2',
        'email',
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
        'lab_number' => 'integer',
        'lab_code' => 'string',
        'name' => 'string',
        'short_code' => 'string',
        'address' => 'string',
        'telephone_1' => 'string',
        'telephone_2' => 'string',
        'email' => 'string',
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
        'lab_number' => 'nullable',
        'lab_code' => 'nullable|string|max:255',
        'name' => 'required|string|max:255',
        'short_code' => 'required|string|max:255',
        'address' => 'nullable|string|max:255',
        'telephone_1' => 'nullable|string|max:255',
        'telephone_2' => 'nullable|string|max:255',
        'email' => 'nullable|string|max:255',
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
    public function hospital()
    {
        return $this->belongsTo(\App\Models\Hospital::class, 'hospital_id');
    }
}
