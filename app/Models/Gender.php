<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Gender
 * @package App\Models
 * @version August 22, 2020, 4:46 pm UTC
 *
 * @property string $short_code
 * @property string $description
 * @property integer $hospital_id
 * @property integer $branch_id
 */
class Gender extends Model
{
    use SoftDeletes;

    public $table = 'genders';
    
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
        'short_code' => 'required',
        'description' => 'required',
        'hospital_id' => 'required',
        'branch_id' => 'required'
    ];

    
}
