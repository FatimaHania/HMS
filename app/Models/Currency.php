<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use App\Scopes\HospitalScope;

/**
 * Class Currency
 * @package App\Models
 * @version September 14, 2020, 6:30 pm UTC
 *
 * @property string $short_code
 * @property string $description
 * @property integer $decimal_places
 * @property integer $exchange_rate
 * @property boolean $is_default
 * @property integer $hospital_id
 * @property integer $branch_id
 */
class Currency extends Model
{
    use SoftDeletes;

    public $table = 'currencies';
    
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';


    protected $dates = ['deleted_at'];



    public $fillable = [
        'short_code',
        'description',
        'decimal_places',
        'exchange_rate',
        'is_default',
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
        'decimal_places' => 'integer',
        'exchange_rate' => 'integer',
        'is_default' => 'boolean',
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
        'decimal_places' => 'required|integer',
        'exchange_rate' => 'required|integer',
        'is_default' => 'required|boolean',
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
