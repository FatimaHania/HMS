<?php

namespace App\Repositories;

use App\Models\Session;
use App\Models\User;
use App\Repositories\BaseRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use \DateTime;
use \DateInterval;
use \DatePeriod;

/**
 * Class SessionRepository
 * @package App\Repositories
 * @version October 5, 2020, 5:57 pm UTC
*/

class SessionRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
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
        return Session::class;
    }

    public function getAll(){
        return Session::with(['physician','department','room','currency'])->get();
    }


    public function getSessionDates($physician_id) {

        $session_dates = Session::where('physician_id' , $_POST['physician_id'])->orderBy('Date', 'DESC')->get();

        $session_date_option = "<option value='0'>Select Date</option>";
        foreach ($session_dates as $session_date) {
            $session_date_option .= "<option value='". $session_date->date ."'> ". date('jS M, Y', strtotime($session_date->date)) ." </option>";
        }

        return $session_date_option;

    }


    public function getSessionDetails($physician_id, $session_date) {

        if($session_date == null || $session_date == 0 || $session_date == ""){
            $physician_session = Session::where(['physician_id' => $physician_id])->orderBy('Date', 'DESC')->get();
        } else {
            $physician_session = Session::where(['physician_id' => $physician_id , 'date' => $session_date])->orderBy('Date', 'DESC')->get();
        }

        return $physician_session;

    }

    public function getPreviousSessionDate($physician_id,$session_date) {

        $previous_session = Session::where([['physician_id' , '=', $physician_id] , ['date','<',$session_date]])->offset(0)->limit(1)->get();
        return $previous_session;

    }


    public function cancelSession($session_id, $cancelled_date, $cancelled_by, $cancelled_reason) {

        $cancel_session = Session::where('id', $session_id)
            ->update(['is_cancelled' => 1 , 'cancelled_date' => $cancelled_date , 'cancelled_by' => Auth::user()->id , 'cancelled_reason' => $cancelled_reason]);
        
        return $cancel_session;

    }

    public function startSession($session_id, $started_at, $started_by) {

        $start_session = Session::where('id', $session_id)
            ->update(['starts_at' => $started_at , 'started_by' => Auth::user()->id]);
        
        return $start_session;

    }

    public function completeSession($session_id, $completed_at, $completed_by) {

        $complete_session = Session::where('id', $session_id)
            ->update(['completed_at' => $completed_at , 'completed_by' => Auth::user()->id]);
        
        return $complete_session;

    }

    public function checkRoomAvailablity($session_id, $room_id, $start_time, $end_time, $session_dates_arr) {

        $sessions = array();
        $data['status'] = '';
        $data['message'] = '';
        foreach ($session_dates_arr as $dt) {
            $date = date("Y-m-d" , strtotime($dt));

            $session = Session::where([['room_id', $room_id] , ['date', $date] , ['start_time' , '<=' , $start_time] , ['end_time' , '>' , $start_time]])
                ->orWhere([['room_id', $room_id] , ['date', $date] , ['start_time' , '<' , $end_time] , ['end_time' , '>=' , $end_time]])
                ->where('id', '!=' , $session_id)
                ->first();

            

            if(!empty($session)){
                $data['status'] = 'unavailable';
                $data['message'] = 'The room '. $session->room->short_code .' has already been taken for session '.$session->name.' by '. $session->physician->title->short_code.' '.$session->physician->physician_name. '. Please select a different room.';
            }

        }
        
        return json_encode($data);

    }




    /** PUBLIC PORTAL */
    public function getSessionsPP($date_from=0, $date_to=0)
    {

        $user_hospitals = DB::select('select * from user_hospital where user_id="'.Auth::user()->id.'"');

        $link_physician_id_arr = array();
        foreach($user_hospitals as $user_hospital){
            if($user_hospital->is_approved_by_hospital == '1'){//link approved by the hospital
                if($user_hospital->link_verified_at !== NULL) { //link verified through email
                    if($user_hospital->is_physician == '1') { //physicians
                        $link_physician_id_arr[] = $user_hospital->user_link_id;
                    }
                }
            }
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

            $date_sessions = Session::withoutGlobalScope(HospitalScope::class)->where('date' , '=' , $date)->whereIn('physician_id', $link_physician_id_arr)->orderBy('date', 'DESC')->orderBy('start_time', 'ASC');

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

}
