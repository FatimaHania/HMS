<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateCheckupRequest;
use App\Http\Controllers\AppBaseController;
use App\Repositories\CheckupRepository;
use App\Repositories\PatientRepository;
use App\Repositories\AppointmentRepository;
use App\Repositories\PatientHeightRepository;
use App\Repositories\PatientWeightRepository;
use Illuminate\Http\Request;
use Session;
use Flash;
use Response;
use PDF;

class CheckupController extends Controller
{

    /** @var  CheckupRepository */
    /** @var  PatientRepository */
    /** @var  AppointmentRepository */
    /** @var  PatientHeightRepository */
    /** @var  PatientWeightRepository */
    private $checkupRepository;
    private $patientRepository;
    private $appointmentRepository;
    private $patientHeightRepository;
    private $patientWeightRepository;

    public function __construct(CheckupRepository $checkupRepo, PatientRepository $patientRepo, AppointmentRepository $appointmentRepo, PatientHeightRepository $patientHeightRepo, PatientWeightRepository $patientWeightRepo)
    {
        $this->checkupRepository = $checkupRepo;
        $this->patientRepository = $patientRepo;
        $this->appointmentRepository = $appointmentRepo;
        $this->patientHeightRepository = $patientHeightRepo;
        $this->patientWeightRepository = $patientWeightRepo;
    }

    /**
     * Show the history of Checkup.
     *
     */
    public function history($description)
    {

        $patient_id = session('history_patient_id');
        $user_id = session('history_user_id');
        $appointment_id = session('history_appointment_id');
        $back_page = session('history_back_page');

        $checkup_history = $this->checkupRepository->getCheckupHistory($patient_id,$user_id);
        $appointment = $this->appointmentRepository->find($appointment_id);
        $patient = $this->patientRepository->find($patient_id);

        return view('public_portal.checkups.history')
            ->with('back_page' , $back_page)
            ->with('appointment' , $appointment)
            ->with('patient' , $patient)
            ->with('checkup_history' , $checkup_history);

    }
    
    /**
     * Show the form for creating a new Checkup.
     *
     * @return Response
     */
    public function create()
    {

        if(Session::has('phy_appointment_id')){
            $appointment_id = session('phy_appointment_id');
        } else {
            $appointment_id = '0';
        }

        $appointment = $this->appointmentRepository->find($appointment_id);

        $patient_height = 0;
        $patient_weight = 0;
        if(!empty($appointment)){
            $patient_height = $this->patientHeightRepository->getLastHeightRecord($appointment->patient_id);
            $patient_weight = $this->patientWeightRepository->getLastWeightRecord($appointment->patient_id);
        }

        return view('public_portal.checkups.create')
                ->with('appointment' , $appointment)
                ->with('last_height' , $patient_height)
                ->with('last_weight' , $patient_weight);
    }

    /**
     * Insert Patient Height
     *
     */
    public function insertPatientHeight()
    {

        return $this->patientHeightRepository->insertPatientHeight($_POST['patient_id'] , $_POST['height_date'] ,$_POST['height_value'] , $_POST['height_unit'] , $_POST['hospital_id'] , $_POST['branch_id']);

    }


    /**
     * Insert Patient Weight
     *
     */
    public function insertPatientWeight()
    {

        return $this->patientWeightRepository->insertPatientWeight($_POST['patient_id'] , $_POST['weight_date'] ,$_POST['weight_value'] , $_POST['weight_unit'] , $_POST['hospital_id'] , $_POST['branch_id']);

    }


    /**
     * Store a newly created Checkup in storage.
     *
     * @param CreateCheckupRequest $request
     *
     * @return Response
     */
    public function store(CreateCheckupRequest $request)
    {
        $input = $request->all();

        if(request('attachment')) {

            $input['attachment'] = request('attachment')->storeAs('images/checkups' , 'CHK-'.session('hospital_id').session('branch_id').$input['appointment_id'].'.'.($request->attachment->extension()));

        }

        $checkup = $this->checkupRepository->create($input);
        $update_is_attended = $this->appointmentRepository->updateIsPatientAttended($input['appointment_id']);

        Flash::success('Treatment saved successfully.');

        //store patient id in session to view patient checkup history
        session(['history_patient_id' => $input['patient_id']]);
        session(['history_appointment_id' => $input['appointment_id']]);
        session(['history_back_page' => 'physician_appointments']);

        return redirect()->route('checkup.history' , 'checkup_history');

    }


    /**
     * Redirect to medical history from create new medical record page
     *
     */
    public function redirectToHistory()
    {

        session(['history_patient_id' => $_POST['patient_id']]);
        session(['history_user_id' => '']);
        session(['history_appointment_id' => $_POST['appointment_id']]);
        session(['history_back_page' => 'create_medical_record']);
        
    }


    public function printPrescription()
    {

        $checkup_id = $_POST['checkup_id'];

        $checkup = $this->checkupRepository->getCheckupRecord($checkup_id);

        $pdf = PDF::loadView('public_portal.checkups.pdf_prescription', compact('checkup'));
    
        return $pdf->stream('prescription_'.date('d-m-Y').'.pdf');

    }


}
