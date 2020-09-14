<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use Carbon\Carbon;
use App\Scopes\HospitalScope;

/**
 * Class Physician
 * @package App\Models
 * @version September 6, 2020, 4:10 pm UTC
 *
 * @property \App\Models\Branch $branch
 * @property \App\Models\Country $country
 * @property \App\Models\Gender $gender
 * @property \App\Models\Hospital $hospital
 * @property \App\Models\Nationality $nationality
 * @property \App\Models\Title $title
 * @property integer $physician_number
 * @property string $physician_code
 * @property string $physician_name
 * @property string $physician_image
 * @property integer $title_id
 * @property integer $gender_id
 * @property string $dob
 * @property integer $country_id
 * @property integer $nationality_id
 * @property string $passport_no
 * @property string $mobile
 * @property string $telephone
 * @property string $address
 * @property string $email
 * @property integer $hospital_id
 * @property integer $branch_id
 */
class Physician extends Model
{
    use SoftDeletes;

    public $table = 'physicians';
    
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';


    protected $dates = ['deleted_at'];



    public $fillable = [
        'physician_number',
        'physician_code',
        'physician_name',
        'physician_image',
        'title_id',
        'gender_id',
        'dob',
        'country_id',
        'nationality_id',
        'passport_no',
        'mobile',
        'telephone',
        'address',
        'email',
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
        'physician_number' => 'integer',
        'physician_code' => 'string',
        'physician_name' => 'string',
        'physician_image' => 'string',
        'title_id' => 'integer',
        'gender_id' => 'integer',
        'dob' => 'date',
        'country_id' => 'integer',
        'nationality_id' => 'integer',
        'passport_no' => 'string',
        'mobile' => 'string',
        'telephone' => 'string',
        'address' => 'string',
        'email' => 'string',
        'hospital_id' => 'integer',
        'branch_id' => 'integer'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'physician_number' => 'required|integer',
        'physician_code' => 'nullable|string|max:255',
        'physician_name' => 'nullable|string|max:255',
        'physician_image' => '',
        'title_id' => 'required',
        'gender_id' => 'required',
        'dob' => 'nullable',
        'country_id' => '',
        'nationality_id' => '',
        'passport_no' => 'nullable|string|max:255',
        'mobile' => 'required',
        'telephone' => '',
        'address' => 'nullable|string|max:255',
        'email' => 'nullable|string|max:255',
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




}
