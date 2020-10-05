<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use App\Scopes\HospitalScope;

/**
 * Class Room
 * @package App\Models
 * @version October 2, 2020, 6:08 pm UTC
 *
 * @property \App\Models\Branch $branch
 * @property \App\Models\Hospital $hospital
 * @property string $short_code
 * @property string $description
 * @property integer $sort_order
 * @property integer $hospital_id
 * @property integer $branch_id
 */
class Room extends Model
{
    use SoftDeletes;

    public $table = 'rooms';
    
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';


    protected $dates = ['deleted_at'];



    public $fillable = [
        'short_code',
        'description',
        'sort_order',
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
        'sort_order' => 'integer',
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
        'sort_order' => 'required|integer',
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
