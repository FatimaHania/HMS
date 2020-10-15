<?php

namespace App\Repositories;

use App\Models\Appointment;
use App\Models\Session;
use App\Repositories\BaseRepository;

/**
 * Class AppointmentRepository
 * @package App\Repositories
 * @version October 11, 2020, 3:50 pm UTC
*/

class AppointmentRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
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
     * Return searchable fields
     *
     * @return array
     */
    public function getFieldsSearchable()
    {
        return $this->fieldSearchable;
    }

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Appointment::class;
    }

    public function getAll()
    {
        return Appointment::with(['patient','session','currency'])->get();
    }


    public function getAllSessions() 
    {
        
        $sessions = Session::orderBy('date', 'DESC')->get();

        return $sessions;

    }

    public function getSessionDetail($session_id) 
    {
        
        $session = Session::find($session_id);

        return $session;

    }


    public function getAppointmentDetails($session_id) 
    {
        
        $appointments = Appointment::where(['session_id' => $session_id])->orderBy('appointment_number', 'ASC')->get();

        return $appointments;

    }


}
