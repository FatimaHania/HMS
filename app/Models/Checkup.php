<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Appointment;
use App\Models\Patient;

/**
 * Class Checkup
 * @package App\Models
 * @version September 14, 2020, 6:30 pm UTC
 *
 * @property string $complains
 * @property string $observations
 * @property integer $patient_id
 * @property integer $appointment_id
 * @property string $diagnosis
 * @property string $treatment
 * @property string $prescription
 * @property string $attachment
 */
class Checkup extends Model
{
    
    use SoftDeletes;

    public $table = 'checkups';
    
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';


    protected $dates = ['deleted_at'];



    public $fillable = [
        'patient_id',
        'appointment_id',
        'complains',
        'observations',
        'diagnosis',
        'treatment',
        'prescription',
        'attachment'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'patient_id' => 'integer',
        'appointment_id' => 'integer',
        'complains' => 'string',
        'observations' => 'string',
        'diagnosis' => 'string',
        'treatment' => 'string',
        'prescription' => 'string',
        'attachment' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'patient_id' => 'required|integer',
        'appointment_id' => 'required|integer',
        'complains' => 'nullable|string',
        'observations' => 'nullable|string',
        'treatment' => 'nullable|string',
        'diagnosis' => 'nullable|string',
        'prescription' => 'nullable',
        'attachment' => 'nullable',
        'created_at' => 'nullable',
        'updated_at' => 'nullable',
        'deleted_at' => 'nullable'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function appointment()
    {
        return $this->belongsTo(\App\Models\Appointment::class, 'appointment_id');
    }


    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function patient()
    {
        return $this->belongsTo(\App\Models\Patient::class, 'patient_id');
    }

    //attachment
    public function attachment()
    {

        $value = $this->attachment;

        if($value == "" || $value == null){
            return '/storage/images/sys_no_attachment_image.png';
        } else {
            if (file_exists( public_path() . '/storage/' . $value)) {
                return '/storage/' . $value;
            } else {
                return '/storage/images/sys_no_attachment_image.png';
            }    
        }

    }

}
