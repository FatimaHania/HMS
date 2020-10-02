<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use App\Scopes\HospitalScope;

/**
 * Class Designation
 * @package App\Models
 * @version September 28, 2020, 5:06 pm UTC
 *
 * @property string $title
 * @property string $short_code
 * @property string $description
 * @property integer $hospital_id
 * @property integer $branch_id
 */
class Designation extends Model
{
    use SoftDeletes;

    public $table = 'designations';
    
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';


    protected $dates = ['deleted_at'];



    public $fillable = [
        'title',
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
        'title' => 'string',
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
        'title' => 'required|string|max:255',
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

    
}
