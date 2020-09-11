<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class DocumentCode
 * @package App\Models
 * @version August 27, 2020, 4:57 pm UTC
 *
 * @property \App\Models\Branch $branch
 * @property \App\Models\Documentcode $documentcode
 * @property \App\Models\Hospital $hospital
 * @property integer $documentcode_id
 * @property string $short_code
 * @property string $description
 * @property string $prefix
 * @property integer $starting_no
 * @property integer $format_length
 * @property integer $common_difference
 * @property integer $hospital_id
 * @property integer $branch_id
 */
class DocumentCode extends Model
{
    use SoftDeletes;

    public $table = 'documentcode_hospital';
    
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';


    protected $dates = ['deleted_at'];



    public $fillable = [
        'documentcode_id',
        'short_code',
        'description',
        'prefix',
        'starting_no',
        'format_length',
        'common_difference',
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
        'documentcode_id' => 'integer',
        'short_code' => 'string',
        'description' => 'string',
        'prefix' => 'string',
        'starting_no' => 'integer',
        'format_length' => 'integer',
        'common_difference' => 'integer',
        'hospital_id' => 'integer',
        'branch_id' => 'integer'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'documentcode_id' => 'required',
        'short_code' => 'nullable|string|max:255',
        'description' => 'required|string|max:255',
        'prefix' => 'required|string|max:255',
        'starting_no' => 'required|integer',
        'format_length' => 'required|integer',
        'common_difference' => 'required|integer',
        'hospital_id' => 'required',
        'branch_id' => 'required',
        'created_at' => 'nullable',
        'updated_at' => 'nullable',
        'deleted_at' => 'nullable'
    ];

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
    public function documentcode()
    {
        return $this->belongsTo(\App\Models\Documentcode::class, 'documentcode_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function hospital()
    {
        return $this->belongsTo(\App\Models\Hospital::class, 'hospital_id');
    }
}
