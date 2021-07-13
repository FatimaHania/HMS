<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use App\Scopes\HospitalScope;

/**
 * Class Session
 * @package App\Models
 * @version October 5, 2020, 5:57 pm UTC
 *
 * @property \App\Models\Currency $currency
 * @property \App\Models\Department $department
 * @property \App\Models\Physician $physician
 * @property \App\Models\Room $room
 * @property integer $physician_id
 * @property string $name
 * @property string $date
 * @property time $start_time
 * @property time $end_time
 * @property integer $number_of_slots
 * @property integer $duration_per_slot
 * @property integer $department_id
 * @property integer $room_id
 * @property integer $currency_id
 * @property number $amount_per_slot
 * @property string|\Carbon\Carbon $starts_at
 * @property string|\Carbon\Carbon $completed_at
 * @property boolean $is_cancelled
 */
class Session extends Model
{
    use SoftDeletes;

    public $table = 'sessions';
    
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';


    protected $dates = ['deleted_at'];



    public $fillable = [
        'physician_id',
        'name',
        'date',
        'start_time',
        'end_time',
        'number_of_slots',
        'duration_per_slot',
        'department_id',
        'room_id',
        'currency_id',
        'amount_per_slot',
        'starts_at',
        'completed_at',
        'is_cancelled'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'physician_id' => 'integer',
        'name' => 'string',
        'date' => 'date',
        'number_of_slots' => 'integer',
        'duration_per_slot' => 'integer',
        'department_id' => 'integer',
        'room_id' => 'integer',
        'currency_id' => 'integer',
        'amount_per_slot' => 'decimal:2',
        'starts_at' => 'datetime',
        'completed_at' => 'datetime',
        'is_cancelled' => 'boolean'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'physician_id' => 'required',
        'name' => 'required|string|max:255',
        'date' => 'required',
        'start_time' => 'required',
        'end_time' => 'required',
        'number_of_slots' => 'required|integer',
        'duration_per_slot' => 'required|integer',
        'department_id' => 'required',
        'room_id' => 'required',
        'currency_id' => 'required',
        'amount_per_slot' => 'required|numeric',
        'starts_at' => 'nullable',
        'completed_at' => 'nullable',
        'is_cancelled' => 'boolean',
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
    public function currency()
    {
        return $this->belongsTo(\App\Models\Currency::class, 'currency_id');
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
    public function physician()
    {
        return $this->belongsTo(\App\Models\Physician::class, 'physician_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function room()
    {
        return $this->belongsTo(\App\Models\Room::class, 'room_id');
    }


    /**
     * @return \Illuminate\Database\Eloquent\Relations\hasMany
     **/
    public function appointment()
    {
        return $this->hasMany(\App\Models\Appointment::class, 'session_id');
    }
}
