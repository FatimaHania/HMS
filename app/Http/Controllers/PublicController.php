<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\AppointmentRepository;
use App\Repositories\SessionRepository;

class PublicController extends Controller
{

    /** @var  AppointmentRepository */
    /** @var  SessionRepository */
    private $appointmentRepository;
    private $sessionRepository;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(AppointmentRepository $appointmentRepo , SessionRepository $sessionRepo)
    {
        $this->appointmentRepository = $appointmentRepo;
        $this->sessionRepository = $sessionRepo;
    }

    
    public function redirectToAppointments()
    {

        session(['phy_session_id' => $_POST['session_id']]);
        
    }


    public function redirectToCheckups()
    {

        session(['phy_appointment_id' => $_POST['appointment_id']]);
        
    }


    public function redirectToHistory()
    {

        session(['history_patient_id' => $_POST['patient_id']]);
        session(['history_user_id' => '']);
        session(['history_appointment_id' => $_POST['appointment_id']]);
        session(['history_back_page' => 'physician_appointments']);
        
    }


    public function redirectToHistoryFromDashboard()
    {

        session(['history_patient_id' => '']);
        session(['history_appointment_id' => '']);
        session(['history_back_page' => 'dashboard']);
        session(['history_user_id' => $_POST['user_id']]);

    }

    
    public function getSessionsForBookingPP()
    {

        $branch_id = $_POST['branch_id'];
        $specialization_id = $_POST['specialization_id'];
        $date = $_POST['date'];

        $sessions = $this->sessionRepository->getSessionsForBookingPP($branch_id,$specialization_id,$date);

        return view('public_portal.patient_appointment_booking_sessions')
                ->with('sessions', $sessions);

    }


}
