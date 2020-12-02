<?php

namespace App\Repositories;

use App\Models\Session;
use App\Repositories\BaseRepository;
use Illuminate\Support\Facades\Auth;

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

}
