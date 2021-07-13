<?php

namespace App\Repositories;

use App\Models\Appointment;
use App\Models\Session;
use App\Models\Physician;
use App\Models\Patient;
use App\Models\Specialization;
use App\Models\Room;
use App\Models\Department;
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

    public function getRooms()
    {

        return Room::orderBy('description', 'ASC')->get();

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


    public function getAllSessions($date_from=0, $date_to=0, $physician_id=0, $room_id=0, $specialization_id=0, $status=0) 
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


            if($room_id == "0"){} else{
                $date_sessions->where('sessions.room_id',$room_id );
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
     
        

        return array_reverse($sessions);

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


    /**
     * Get patient turnover details
     **/
    public function getPatientTurnover($type, $date_from, $date_to, $physician_id, $department_id){

        $departments = Department::all();
        $records = array();
        if($type == 'daily'){//daily report

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
    
            foreach ($period as $dt) {
                $date = $dt->format("Y-m-d");

                $department_patient_count_arr = array();
                foreach ($departments as $department){

                    $patient_count_per_department = Appointment::join('sessions','sessions.id','=','appointments.session_id')
                        ->where([['sessions.date' , '=' , $date] , ['sessions.department_id' , '=' , $department->id]])
                        ->count();

                    $department_patient_count_arr[] = array(
                        'department' => $department,
                        'patient_count' => $patient_count_per_department
                    );

                }
    
                

                $records[] = array(
                    'date' => date("d-m-Y", strtotime($date)),
                    'department_patient_count' => $department_patient_count_arr
                );

            }


        } else if($type == 'monthly'){ //monthly report

            if($date_from == "0"){
                $date_from = date('Y-m-d');
            } 
    
            if($date_to == "0"){
                $date_to = date('Y-m-d');
            }

            $start    = new DateTime($date_from);
            $start->modify('first day of this month');
            $end      = new DateTime($date_to);
            $end->modify('first day of next month');
            $interval = DateInterval::createFromDateString('1 month');
            $period   = new DatePeriod($start, $interval, $end);

            foreach ($period as $dt) {
                $year =  $dt->format("Y");
                $month =  $dt->format("m");
                $date_formatted = $dt->format("M Y");

                $department_patient_count_arr = array();
                foreach ($departments as $department){

                    $patient_count_per_department = Appointment::join('sessions','sessions.id','=','appointments.session_id')
                        ->whereYear('sessions.date' , '=' , $year)
                        ->whereMonth('sessions.date' , '=' , $month)
                        ->where([['sessions.date' , '>=' , $date_from] , ['sessions.date' , '<=' , $date_to] , ['sessions.department_id' , '=' , $department->id]])
                        ->count();

                    $department_patient_count_arr[] = array(
                        'department' => $department,
                        'patient_count' => $patient_count_per_department
                    );

                }
    
                

                $records[] = array(
                    'date' => $date_formatted,
                    'department_patient_count' => $department_patient_count_arr
                );

            }

        } else if($type == 'yearly'){ //yearly report

            if($date_from == "0"){
                $date_from = date('Y-m-d');
            } 
    
            if($date_to == "0"){
                $date_to = date('Y-m-d');
            }

            $start    = new DateTime($date_from);
            $start->modify('first day of this year');
            $end      = new DateTime($date_to);
            $end->modify('first day of next year');
            $interval = DateInterval::createFromDateString('1 year');
            $period   = new DatePeriod($start, $interval, $end);

            foreach ($period as $dt) {
                $year =  $dt->format("Y");
                $date_formatted = $dt->format("Y");

                $department_patient_count_arr = array();
                foreach ($departments as $department){

                    $patient_count_per_department = Appointment::join('sessions','sessions.id','=','appointments.session_id')
                        ->whereYear('sessions.date' , '=' , $year)
                        ->where([['sessions.date' , '>=' , $date_from] , ['sessions.date' , '<=' , $date_to] , ['sessions.department_id' , '=' , $department->id]])
                        ->count();

                    $department_patient_count_arr[] = array(
                        'department' => $department,
                        'patient_count' => $patient_count_per_department
                    );

                }
    
                

                $records[] = array(
                    'date' => $date_formatted,
                    'department_patient_count' => $department_patient_count_arr
                );

            }

        }

        return $records;

    }


    /**
     * Get appointment fee collection records for the collection report
     **/
    public function getCollections($type, $date_from, $date_to, $physician_id, $department_id){

        $departments = Department::all();

        $default_currency = session('user_details')[session('branch_id')]['hospitals']->branch_currency_short_code;
        $default_currency_decimal_places = session('user_details')[session('branch_id')]['hospitals']->branch_currency_decimal_places;

        if($date_from == "0"){
            $date_from = date('Y-m-d');
        } 

        if($date_to == "0"){
            $date_to = date('Y-m-d');
        }

        $records = array();
        if($type == 'daily'){//daily report
    
            $begin = new DateTime($date_from);
            $end = new DateTime($date_to);
    
            $end->setTime(0,0,1);     // new line
    
            $interval = DateInterval::createFromDateString('1 day');
            $period = new DatePeriod($begin, $interval, $end);
    
            foreach ($period as $dt) {
                $date = $dt->format("Y-m-d");

                $department_collection_arr = array();
                foreach ($departments as $department){

                    $total_collection = Appointment::join('sessions','sessions.id','=','appointments.session_id')
                        ->where([['sessions.date' , '=' , $date] , ['sessions.department_id' , '=' , $department->id] , ['appointments.is_paid' , '=' , '1']])
                        ->sum('amount');

                    $department_collection_arr[] = array(
                        'department' => $department,
                        'total_collection' => $total_collection
                    );

                }
    
                

                $records[] = array(
                    'date' => date("d-m-Y", strtotime($date)),
                    'department_total_collection' => $department_collection_arr,
                    'default_currency_short_code' => $default_currency,
                    'default_currency_decimal_places' => $default_currency_decimal_places
                );

            }


        } else if($type == 'monthly'){ //monthly report

    
            $start    = new DateTime($date_from);
            $start->modify('first day of this month');
            $end      = new DateTime($date_to);
            $end->modify('first day of next month');
            $interval = DateInterval::createFromDateString('1 month');
            $period   = new DatePeriod($start, $interval, $end);
    
            foreach ($period as $dt) {
                $year =  $dt->format("Y");
                $month =  $dt->format("m");
                $date_formatted = $dt->format("M Y");

                $department_collection_arr = array();
                foreach ($departments as $department){

                    $total_collection = Appointment::join('sessions','sessions.id','=','appointments.session_id')
                        ->whereYear('sessions.date' , '=' , $year)
                        ->whereMonth('sessions.date' , '=' , $month)    
                        ->where([['sessions.date' , '>=' , $date_from] , ['sessions.date' , '<=' , $date_to] ,  ['sessions.department_id' , '=' , $department->id] , ['appointments.is_paid' , '=' , '1']])
                        ->sum('amount');

                    $department_collection_arr[] = array(
                        'department' => $department,
                        'total_collection' => $total_collection
                    );

                }
    
                

                $records[] = array(
                    'date' => $date_formatted,
                    'department_total_collection' => $department_collection_arr,
                    'default_currency_short_code' => $default_currency,
                    'default_currency_decimal_places' => $default_currency_decimal_places
                );

            }

        } else if($type == 'yearly'){ //yearly report

            $start    = new DateTime($date_from);
            $start->modify('first day of this year');
            $end      = new DateTime($date_to);
            $end->modify('first day of next year');
            $interval = DateInterval::createFromDateString('1 year');
            $period   = new DatePeriod($start, $interval, $end);
    
            foreach ($period as $dt) {
                $year =  $dt->format("Y");
                $date_formatted = $dt->format("Y");

                $department_collection_arr = array();
                foreach ($departments as $department){

                    $total_collection = Appointment::join('sessions','sessions.id','=','appointments.session_id')
                        ->whereYear('sessions.date' , '=' , $year)  
                        ->where([['sessions.date' , '>=' , $date_from] , ['sessions.date' , '<=' , $date_to] ,  ['sessions.department_id' , '=' , $department->id] , ['appointments.is_paid' , '=' , '1']])
                        ->sum('amount');

                    $department_collection_arr[] = array(
                        'department' => $department,
                        'total_collection' => $total_collection
                    );

                }
    
                

                $records[] = array(
                    'date' => $date_formatted,
                    'department_total_collection' => $department_collection_arr,
                    'default_currency_short_code' => $default_currency,
                    'default_currency_decimal_places' => $default_currency_decimal_places
                );

            }

        }

        

        return $records;

    }

    public function updateIsPatientAttended($appointment_id)
    {

        Appointment::where('id', $appointment_id)->update(['attended_at' => date('Y-m-d H:i:s')]);

    }

    public function getPatientTurnoverDashboard($date_from,$date_to)
    {

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

        $records = array();
        foreach ($period as $dt) {
            $date = $dt->format("Y-m-d");

            $patient_count = Appointment::join('sessions','sessions.id','=','appointments.session_id')
                        ->where('sessions.date' , '=' , $date)
                        ->count();

            $patient_attended_count = Appointment::join('sessions','sessions.id','=','appointments.session_id')
                        ->join('checkups','checkups.appointment_id','=','appointments.id')
                        ->where('sessions.date' , '=' , $date)
                        ->count();

            $records[] = array(
                'date' => date("d-m-Y", strtotime($date)),
                'patient_count' => $patient_count,
                'patient_attended_count' => $patient_attended_count
            );

        }

        return $records;

    }


}
