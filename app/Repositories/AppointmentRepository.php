<?php

namespace App\Repositories;

use App\Models\Appointment;
use App\Models\Session;
use App\Models\Physician;
use App\Models\Patient;
use App\Models\Specialization;
use App\Helpers\Helper;
use App\Repositories\BaseRepository;
use Illuminate\Support\Facades\Auth;
use \DateTime;
use \DateInterval;
use \DatePeriod;

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

    public function getPhysicians()
    {

        return Physician::orderBy('physician_number', 'ASC')->get();

    }

    public function getSpecializations()
    {

        return Specialization::orderBy('description', 'ASC')->get();

    }

    public function getAllPatients() 
    {
        
        $patients = Patient::all();

        return $patients;

    }

    public function updatePhysicianFilter($specialization_id)
    {

        if($specialization_id == "0" || $specialization_id == "" || $specialization_id == null){
            $physicians = $this->getPhysicians();
        } else {
            $physicians = Specialization::find($specialization_id)->physicians()->get();
        }

        $physician_opt = "";
        foreach($physicians as $physician) {
            $physician_opt .= "<option value='".$physician->id."'>".$physician->physician_code." | ".$physician->physician_name."</option>";
        }

        return $physician_opt;

    }


    public function getAllSessions($date_from=0, $date_to=0, $physician_id=0, $specialization_id=0, $status=0) 
    {

        $physician_id_arr = array();

        //get physicians for selected specialization
        if($specialization_id == "0"){} else {
            $specialziation = Specialization::find($specialization_id);

            $physicians = $specialziation->physicians()->get();

            foreach($physicians as $physician){
                $physician_id_arr[] = $physician->id;
            }

        }

        if($physician_id == "0"){} else {
            $physician_id_arr[] = $physician_id;
        }
        
        if($date_from == "0"){
            $date_from = date('Y-m-d');
        } 

        if($date_to == "0"){
            $date_to = date('Y-m-d');
        }

        $begin = new DateTime($date_from);
        $end = new DateTime($date_to);

        $end->setTime(0,0,1);     // new line

        $interval = DateInterval::createFromDateString('1 day');
        $period = new DatePeriod($begin, $interval, $end);

        $sessions = array();
        foreach ($period as $dt) {
            $date = $dt->format("Y-m-d");

            $date_sessions = Session::where('date' , '=' , $date)->orderBy('date', 'DESC');

            if(!empty($physician_id_arr)){
                $date_sessions->whereIn('sessions.physician_id',$physician_id_arr );
            }

            if($status == "0"){
            } else if($status == "pending"){
                $date_sessions->whereNull('starts_at');
                $date_sessions->whereNull('completed_at');
                $date_sessions->whereNull('cancelled_date');
            } else if($status == "ongoing"){
                $date_sessions->whereNotNull('starts_at');
                $date_sessions->whereNull('completed_at');
                $date_sessions->whereNull('cancelled_date');
            } else if($status == "completed"){
                $date_sessions->whereNotNull('completed_at');
                $date_sessions->whereNull('cancelled_date');
            } else if($status == "cancelled"){
                $date_sessions->whereNotNull('cancelled_date');
            }

            $date_sessions_rec = $date_sessions->get();

            if(count($date_sessions_rec)) {

                $date_sessions_arr = array(
                    "date" => $date,
                    "date_sessions" => $date_sessions_rec
                );

                $sessions[] = $date_sessions_arr;

            }

        }
     
        

        return $sessions;

    }

    public function getTodaySessions() 
    {
        
        $sessions_today = Session::where('date',date('Y-m-d'))->orderBy('start_time', 'ASC')->get();

        return $sessions_today;

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


    public function bookAppointments($session_id, $appointment_number, $appointment_time, $patient_id, $currency_id, $amount_per_slot)
    {
        $selectedSlot = Appointment::where(['session_id' => $session_id , 'appointment_number' => $appointment_number])->first();
        
        if(empty($selectedSlot)){
            $ref_number = Helper::documentCode(4)['serial_number'];
            $ref_code = Helper::documentCode(4)['document_code'];
        } else {
            $ref_number = $selectedSlot->reference_number;
            $ref_code = $selectedSlot->reference_code;
        }

        $appointment = Appointment::updateOrCreate(
            ['session_id' => $session_id, 'appointment_number' => $appointment_number, 'reference_number' => $ref_number, 'reference_code' => $ref_code, 'hospital_id' => session('hospital_id'), 'branch_id' => session('branch_id')],
            ['patient_id' => $patient_id, 'appointment_time' => $appointment_time, 'currency_id' => $currency_id, 'amount' => $amount_per_slot]
        );

        $session_appointments = $this->getAppointmentDetails($session_id);

        return array(
            "ref_code" => $ref_code,
            "number_of_appointments" => count($session_appointments)
        );

    }


    public function cancelAppointments($session_id, $appointment_number)
    {

        $cancelAppointment = Appointment::where(['session_id' => $session_id , 'appointment_number' => $appointment_number, 'hospital_id' => session('hospital_id'), 'branch_id' => session('branch_id')])->delete();

        $session_appointments = $this->getAppointmentDetails($session_id);

        return array(
            "number_of_appointments" => count($session_appointments),
            "status" => $cancelAppointment
        );

    }


    public function updatePaymentStatus($appointment_id, $paid_at, $received_by)
    {

        $appoinment = Appointment::find($appointment_id);

        $appoinment->is_paid = '1';
        $appoinment->payment_received_by = Auth::user()->id;
        $appoinment->payment_received_date = $paid_at;

        $appoinment->save();

    }


}
