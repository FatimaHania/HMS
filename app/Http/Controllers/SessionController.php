<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateSessionRequest;
use App\Http\Requests\UpdateSessionRequest;
use App\Repositories\SessionRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Response;
use \DateTime;
use \DateInterval;
use \DatePeriod;

use App\Models\Session;
use App\Models\Physician;
use App\Models\Department;
use App\Models\Room;
use App\Models\Currency;

class SessionController extends AppBaseController
{

    private $editedPhysicianId;
    private $editedSessionId;

    /** @var  SessionRepository */
    private $sessionRepository;

    public function __construct(SessionRepository $sessionRepo)
    {
        $this->sessionRepository = $sessionRepo;
    }

    public function storeSessionDetails($editedPhysicianId,$editedSessionDate)
    {

        session()->flash('editedPhysicianId', $editedPhysicianId);
        session()->flash('editedSessionDate', $editedSessionDate);

    }

    /**
     * Display a listing of the Session.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function index(Request $request)
    {
        $sessions = $this->sessionRepository->getAll();

        

        $physicians = Physician::all();

        $session_dates = Session::pluck('date' , 'id');

        return view('sessions.index')
            ->with('sessions', $sessions)
            ->with('physicians', $physicians)
            ->with('session_dates', $session_dates);
    }

    /**
     * Show the form for creating a new Session.
     *
     * @return Response
     */
    public function create()
    {

        $physicians = Physician::all()->pluck('physician' , 'id');
        $departments = Department::pluck('description' , 'id');
        $rooms = Room::pluck('description' , 'id');
        $currencies = Currency::pluck('short_code' , 'id');

        return view('sessions.create')
        ->with('physicians', $physicians)
        ->with('departments', $departments)
        ->with('rooms', $rooms)
        ->with('currencies', $currencies);
    }

    /**
     * Store a newly created Session in storage.
     *
     * @param CreateSessionRequest $request
     *
     * @return Response
     */
    public function store(CreateSessionRequest $request)
    {
        $input = $request->all();

        $date_from = $input['start_date'];
        $date_to = $input['end_date'];

        $session_dates_arr = $input['session_dates_arr'];

        $begin = new DateTime($date_from);
        $end = new DateTime($date_to);
    
        $end->setTime(0,0,1);     // new line
    
        $interval = DateInterval::createFromDateString('1 day');
        $period = new DatePeriod($begin, $interval, $end);
    
        foreach ($session_dates_arr as $dt) {

            $input['date'] = date("Y-m-d" , strtotime($dt));

            $session = $this->sessionRepository->create($input);

        }

        Flash::success('Session saved successfully.');

        return redirect(route('sessions.index'));
        
    }

    /**
     * Display the specified Session.
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $session = $this->sessionRepository->find($id);

        if (empty($session)) {
            Flash::error('Session not found');

            return redirect(route('sessions.index'));
        }

        $this->storeSessionDetails($session->physician_id,$session->date);

        return view('sessions.show')->with('session', $session);

    }

    /**
     * Show the form for editing the specified Session.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit($id)
    {

        $physicians = Physician::all()->pluck('physician' , 'id');
        $departments = Department::pluck('description' , 'id');
        $rooms = Room::pluck('description' , 'id');
        $currencies = Currency::pluck('short_code' , 'id');

        $session = $this->sessionRepository->find($id);

        if (empty($session)) {
            Flash::error('Session not found');

            return redirect(route('sessions.index'));
        }

        $this->storeSessionDetails($session->physician_id,$session->date);

        return view('sessions.edit')
        ->with('session', $session)
        ->with('physicians', $physicians)
        ->with('departments', $departments)
        ->with('rooms', $rooms)
        ->with('currencies', $currencies);

    }

    /**
     * Update the specified Session in storage.
     *
     * @param int $id
     * @param UpdateSessionRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateSessionRequest $request)
    {
        $session = $this->sessionRepository->find($id);

        $editedPhysicianId = $session->physician_id;
        $editedSessionDate = $session->date;

        if (empty($session)) {
            Flash::error('Session not found');

            return redirect(route('sessions.index'));
        }


        $input = $request->all();
        $session_dates_arr = $input['session_dates_arr'];

        foreach ($session_dates_arr as $dt) {
            $input['date'] = date("Y-m-d" , strtotime($dt)); //session_dates_arr array has only one date (ie, the edited date)
        }
        $session = $this->sessionRepository->update($input, $id);

        $this->storeSessionDetails($session->physician_id,$session->date);

        Flash::success('Session updated successfully.');

        return redirect(route('sessions.index'));

    }


    /**
     * get session dates from storage.
     *
     */
    public function getSessionDates()
    {

        $physician_id = $_POST['physician_id'];
        
        $session_dates = $this->sessionRepository->getSessionDates($physician_id);

        return $session_dates;

    }


    public function getSessionDetails()
    {

        $physician_id = $_POST['physician_id'];
        $session_date = $_POST['session_date'];

        $physician_sessions = $this->sessionRepository->getSessionDetails($physician_id, $session_date);

        return view('sessions.table')
            ->with('sessions', $physician_sessions);

    }


    public function cancelSession()
    {

        $session_id = $_POST['session_id'];
        $cancelled_date = $_POST['cancelled_date'];
        $cancelled_by = $_POST['cancelled_by'];
        $cancelled_reason = $_POST['cancelled_reason'];

        return $this->sessionRepository->cancelSession($session_id, $cancelled_date, $cancelled_by, $cancelled_reason);
        
    }

    public function startSession()
    {

        $session_id = $_POST['session_id'];
        $started_at = $_POST['started_at'];
        $started_by = $_POST['started_by'];

        return $this->sessionRepository->startSession($session_id, $started_at, $started_by);
        
    }

    public function completeSession()
    {

        $session_id = $_POST['session_id'];
        $completed_at = $_POST['completed_at'];
        $completed_by = $_POST['completed_by'];

        return $this->sessionRepository->completeSession($session_id, $completed_at, $completed_by);
        
    }

    /**
     * Check room availablity for sessions
     *
     *
     */
    public function checkRoomAvailablity()
    {

        $session_id = $_POST['session_id'];
        $room_id = $_POST['room_id'];
        $start_time = $_POST['start_time'];
        $end_time = $_POST['end_time'];
        $session_dates_arr = $_POST['session_dates_arr'];

        return $this->sessionRepository->checkRoomAvailablity($session_id, $room_id, $start_time, $end_time, $session_dates_arr);

    }


    /**
     * Remove the specified Session from storage.
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        $session = $this->sessionRepository->find($id);

        $session_previous = $this->sessionRepository->getPreviousSessionDate($session->physician_id,$session->date);

        $this->storeSessionDetails($session->physician_id,$session_previous[0]->date);

        if (empty($session)) {
            Flash::error('Session not found');

            return redirect(route('sessions.index'));
        }

        $this->sessionRepository->delete($id);

        Flash::success('Session deleted successfully.');

        return redirect(route('sessions.index'));
    }




    /** PUBLIC PORTAL */
    /**
     * get sessions.
     *
     */
    public function getSessionsPP()
    {

        $date_from = $_POST['date_from'];
        $date_to = $_POST['date_to'];

        $sessions = $this->sessionRepository->getSessionsPP($date_from, $date_to);
        return view('public_portal.physician_sessions')
            ->with('sessions',$sessions);

    }



}
