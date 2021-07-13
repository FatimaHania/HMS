<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use Carbon\Carbon;
use App\Scopes\HospitalScope;

/**
 * Class Appointment
 * @package App\Models
 * @version October 11, 2020, 3:50 pm UTC
 *
 * @property \App\Models\Branch $branch
 * @property \App\Models\Currency $currency
 * @property \App\Models\Hospital $hospital
 * @property \App\Models\Patient $patient
 * @property \App\Models\Session $session
 * @property \App\Models\Checkup $checkup
 * @property integer $reference_number
 * @property string $reference_code
 * @property integer $session_id
 * @property integer $patient_id
 * @property integer $appointment_number
 * @property time $appointment_time
 * @property integer $hospital_id
 * @property integer $branch_id
 * @property integer $currency_id
 * @property number $amount
 * @property boolean $is_paid
 * @property string|\Carbon\Carbon $attended_at
 * @property string|\Carbon\Carbon $cancelled_at
 */
class Appointment extends Model
{
    use SoftDeletes;

    public $table = 'appointments';
    
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';


    protected $dates = ['deleted_at'];



    public $fillable = [
        'reference_number',
        'reference_code',
        'session_id',
        'patient_id',
        'appointment_number',
        'appointment_time',
        'hospital_id',
        'branch_id',
        'currency_id',
        'amount',
        'is_paid',
        'attended_at',
        'cancelled_at'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'reference_number' => 'integer',
        'reference_code' => 'string',
        'session_id' => 'integer',
        'patient_id' => 'integer',
        'appointment_number' => 'integer',
        'hospital_id' => 'integer',
        'branch_id' => 'integer',
        'currency_id' => 'integer',
        'amount' => 'decimal:2',
        'is_paid' => 'boolean',
        'attended_at' => 'datetime',
        'cancelled_at' => 'datetime'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'reference_number' => 'required',
        'reference_code' => 'nullable|string|max:255',
        'session_id' => 'required',
        'patient_id' => 'required',
        'appointment_number' => 'required|integer',
        'appointment_time' => 'nullable',
        'hospital_id' => 'required',
        'branch_id' => 'required',
        'currency_id' => 'required',
        'amount' => 'required|numeric',
        'is_paid' => 'required|boolean',
        'attended_at' => 'nullable',
        'cancelled_at' => 'nullable',
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
    public function currency()
    {
        return $this->belongsTo(\App\Models\Currency::class, 'currency_id');
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

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function session()
    {
        return $this->belongsTo(\App\Models\Session::class, 'session_id');
    }


    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     **/
    public function checkup()
    {
        return $this->hasOne(Checkup::class, 'appointment_id');
    }

}
