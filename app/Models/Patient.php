<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use Carbon\Carbon;
use App\Scopes\HospitalScope;

/**
 * Class Patient
 * @package App\Models
 * @version August 23, 2020, 5:20 pm UTC
 *
 * @property \App\Models\Bloodgroup $bloodgroup
 * @property \App\Models\Branch $branch
 * @property \App\Models\Country $country
 * @property \App\Models\Gender $gender
 * @property \App\Models\Hospital $hospital
 * @property \App\Models\Nationality $nationality
 * @property \App\Models\Title $title
 * @property \App\Models\DocumentCode $documentcode
 * @property string $patient_code
 * @property string $patient_name
 * @property string $patient_number
 * @property string $patient_image
 * @property integer $title_id
 * @property integer $gender_id
 * @property string $dob
 * @property string $dod
 * @property integer $country_id
 * @property integer $nationality_id
 * @property string $passport_no
 * @property string $mobile
 * @property string $telephone
 * @property string $address
 * @property string $email
 * @property integer $bloodgroup_id
 * @property integer $hospital_id
 * @property integer $branch_id
 */
class Patient extends Model
{
    use SoftDeletes;

    public $table = 'patients';
    
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';


    protected $dates = ['deleted_at' , 'created_at' , 'updated_at' ,'dob','dod'];



    public $fillable = [
        'patient_code',
        'patient_number',
        'patient_name',
        'patient_image',
        'title_id',
        'gender_id',
        'dob',
        'dod',
        'country_id',
        'nationality_id',
        'passport_no',
        'mobile',
        'telephone',
        'address',
        'email',
        'bloodgroup_id',
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
        'patient_code' => 'string',
        'patient_number' => 'integer',
        'patient_name' => 'string',
        'patient_image' => 'string',
        'title_id' => 'integer',
        'gender_id' => 'integer',
        'dob' => 'date',
        'dod' => 'date',
        'country_id' => 'integer',
        'nationality_id' => 'integer',
        'passport_no' => 'string',
        'mobile' => 'string',
        'telephone' => 'string',
        'address' => 'string',
        'email' => 'string',
        'bloodgroup_id' => 'integer',
        'hospital_id' => 'integer',
        'branch_id' => 'integer'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'patient_image' => '',
        'patient_number' => 'required',
        'patient_name' => 'required',
        'patient_code' => 'nullable|string|max:255',
        'title_id' => 'required',
        'gender_id' => 'required',
        'dob' => 'required',
        'dod' => '',
        'country_id' => 'required',
        'nationality_id' => 'required',
        'passport_no' => 'required',
        'mobile' => 'required',
        'telephone' => '',
        'address' => 'required',
        'email' => '',
        'bloodgroup_id' => '',
        'hospital_id' => 'required',
        'branch_id' => 'required'
    ];


    protected static function booted()
    {
        static::addGlobalScope(new HospitalScope);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function bloodgroup()
    {
        return $this->belongsTo(\App\Models\Bloodgroup::class, 'bloodgroup_id');
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
    public function country()
    {
        return $this->belongsTo(\App\Models\Country::class, 'country_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function gender()
    {
        return $this->belongsTo(\App\Models\Gender::class, 'gender_id');
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
    public function nationality()
    {
        return $this->belongsTo(\App\Models\Nationality::class, 'nationality_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function title()
    {
        return $this->belongsTo(\App\Models\Title::class, 'title_id');
    }


    // ACCESSORS AND MUTATORS
    //DOB - Accessor & Mutator
    public function getDobAttribute($value)
    {
        return Carbon::parse($value)->format('Y-m-d');
    }

    public function setDobAttribute($value)
    {
        $this->attributes['dob'] = Carbon::parse($value)->format('Y-m-d');
    }


   //DOD - Accessor & Mutator
   public function getDodAttribute($value)
    {
        return Carbon::parse($value)->format('Y-m-d');
    }

    public function setDodAttribute($value)
    {
        $this->attributes['dod'] = Carbon::parse($value)->format('Y-m-d');
    }


}
