<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

use Illuminate\Http\Request;
use App\Models\Branch;
use App\Models\Patient;
use App\Models\Physician;
use App\Models\Nurse;
use App\Models\Hospital;
use App\Models\Specialization;
use App\Repositories\AppointmentRepository;
use App\Repositories\SessionRepository;
use App\User;

class HomeController extends Controller
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
        $this->middleware('auth');
        $this->appointmentRepository = $appointmentRepo;
        $this->sessionRepository = $sessionRepo;
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {


        if(Auth::user()->usertype_id == '1'){
            //Hospital user
            $branches = Branch::all();
            $patient_count = Patient::count();
            $physician_count = Physician::count();
            $nurse_count = Nurse::count();
            $patient_turnover_records = $this->appointmentRepository->getPatientTurnoverDashboard(date('Y-m-d'), date('Y-m-d'));
            $patient_turnover_chart = $this->appointmentRepository->getPatientTurnoverDashboard(date('Y-m-d', strtotime('-7 days')), date('Y-m-d'));
            $upcoming_sessions = $this->sessionRepository->getSessionsPerDate(date('Y-m-d'), date('Y-m-d'));

            return view('home')
                ->with('patient_count', $patient_count)
                ->with('physician_count', $physician_count)
                ->with('nurse_count', $nurse_count)
                ->with('patient_turnover_records', $patient_turnover_records)
                ->with('patient_turnover_chart', $patient_turnover_chart)
                ->with('upcoming_sessions', $upcoming_sessions)
                ->with('branches', $branches);

        } else if(Auth::user()->usertype_id == '2'){
            //public user - patient or physician
            $is_hospital_user = '0';
            $branches = Branch::all();
            $specializations = Specialization::all();
            $user = new User;
            $physicianHospitals = $user->getPhysicianHospitals(Auth::user()->id);
            $patientHospitals = $user->getPatientHospitals(Auth::user()->id);


            return view('home')
                ->with('branches', $branches)
                ->with('specializations', $specializations)
                ->with('physicianHospitals', $physicianHospitals)
                ->with('patientHospitals', $patientHospitals);
        } else {
            return view('home');
        }

        
    }
}
