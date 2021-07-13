<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateAppointmentRequest;
use App\Http\Requests\UpdateAppointmentRequest;
use App\Repositories\AppointmentRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Response;
use Illuminate\Validation\Rule;
use Validator;

use App\Models\Currency;
use App\Models\Patient;
use App\Models\Session;
use App\Models\DocumentCode;
use App\Models\Appointment;

class AppointmentController extends AppBaseController
{
    /** @var  AppointmentRepository */
    private $appointmentRepository;

    public function __construct(AppointmentRepository $appointmentRepo)
    {
        $this->appointmentRepository = $appointmentRepo;
    }

    public function storeSessionDetails($editedAppointmentId,$editedSessionId)
    {

        session()->flash('editedSessionId', $editedSessionId);
        session()->flash('editedAppointmentId', $editedAppointmentId);

    }

    /**
     * Display a listing of the Appointment.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function index(Request $request)
    {
        $appointments = $this->appointmentRepository->getAll();
        $sessions = $this->appointmentRepository->getAllSessions();
        $sessions_today = $this->appointmentRepository->getTodaySessions();
        $physicians = $this->appointmentRepository->getPhysicians();
        $specializations = $this->appointmentRepository->getSpecializations();
        $rooms = $this->appointmentRepository->getRooms();

        return view('appointments.index')
            ->with('appointments', $appointments)
            ->with('sessions', $sessions)
            ->with('physicians', $physicians)
            ->with('rooms', $rooms)
            ->with('specializations', $specializations);
    }

    /**
     * Show the form for creating a new Appointment.
     *
     * @return Response
     */
    public function create()
    {

        $currency = Currency::pluck('short_code' , 'id');
        $patient = Patient::pluck('patient_name' , 'id');
        $session = Session::where([['is_cancelled','!=','1']])->orWhereNull('completed_at')->orderBy('date','DESC')->pluck('name' , 'id');
        $documentCode = DocumentCode::where('documentcode_id' , 4)->first();
        $lastAppointmentRecord = Appointment::orderBy('appointment_number', 'DESC')->first();

        return view('appointments.create')
        ->with('currency', $currency)
        ->with('patient', $patient)
        ->with('session', $session)
        ->with('documentCode', $documentCode)
        ->with('lastAppointmentRecord', $lastAppointmentRecord);
    }

    /**
     * Store a newly created Appointment in storage.
     *
     * @param CreateAppointmentRequest $request
     *
     * @return Response
     */
    public function store(CreateAppointmentRequest $request)
    {
        $input = $request->all();

        Validator::make($input, [
            'reference_code' => [
                'required',
                Rule::unique('appointments')->where(function ($query) {
                    $query->where('branch_id', session('branch_id'));
                }),
            ],
        ])->validate();

        $appointment = $this->appointmentRepository->create($input);

        Flash::success('Appointment saved successfully.');

        return redirect(route('appointments.index'));
    }

    /**
     * Display the specified Appointment.
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $appointment = $this->appointmentRepository->find($id);

        $this->storeSessionDetails($id,$appointment->session_id);

        if (empty($appointment)) {
            Flash::error('Appointment not found');

            return redirect(route('appointments.index'));
        }

        return view('appointments.show')->with('appointment', $appointment);
    }

    /**
     * Show the form for editing the specified Appointment.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $appointment = $this->appointmentRepository->find($id);

        if (empty($appointment)) {
            Flash::error('Appointment not found');

            return redirect(route('appointments.index'));
        }

        $currency = Currency::pluck('short_code' , 'id');
        $patient = Patient::pluck('patient_name' , 'id');
        $session_detail = $this->appointmentRepository->getSessionDetail($appointment->session_id);
        $session = Session::where([['is_cancelled','!=','1']])->orWhereNull('completed_at')->orderBy('date','DESC')->pluck('name' , 'id');
        $documentCode = DocumentCode::where('documentcode_id' , 4)->first();
        $lastAppointmentRecord = Appointment::orderBy('appointment_number', 'DESC')->first();

        $this->storeSessionDetails($id,$appointment->session_id);

        return view('appointments.edit')
        ->with('appointment', $appointment)
        ->with('currency', $currency)
        ->with('patient', $patient)
        ->with('session_detail', $session_detail)
        ->with('session', $session)
        ->with('documentCode', $documentCode)
        ->with('lastAppointmentRecord', $lastAppointmentRecord);
    }

    /**
     * Update the specified Appointment in storage.
     *
     * @param int $id
     * @param UpdateAppointmentRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateAppointmentRequest $request)
    {
        $appointment = $this->appointmentRepository->find($id);

        $input = $request->all();

        Validator::make($input, [
            'reference_code' => [
                'required',
                Rule::unique('appointments')->ignore($id)->whereNull('deleted_at')->where(function ($query) {
                    $query->where('branch_id', session('branch_id'));
                }),
            ],
        ])->validate();

        $this->storeSessionDetails($id,$appointment->session_id);

        if (empty($appointment)) {
            Flash::error('Appointment not found');

            return redirect(route('appointments.index'));
        }

        $appointment = $this->appointmentRepository->update($request->all(), $id);

        Flash::success('Appointment updated successfully.');

        return redirect(route('appointments.index'));
    }

    public function updatePhysicianFilter()
    {

        $specialization_id = $_POST['specialization_id'];

        return $this->appointmentRepository->updatePhysicianFilter($specialization_id);

    }


    public function getAppointmentDetails()
    {

        $session_id = $_POST['session_id'];

        $appointments = $this->appointmentRepository->getAppointmentDetails($session_id);

        $session_details = $this->appointmentRepository->getSessionDetail($session_id);

        return view('appointments.table')
            ->with('session', $session_details)
            ->with('appointments', $appointments);

    }

    public function getCards()
    {

        $date_from = $_POST['date_from'];
        $date_to = $_POST['date_to'];
        $physician_id = $_POST['physician_id'];
        $specialization_id = $_POST['specialization_id'];
        $room_id = $_POST['room_id'];
        $status = $_POST['status'];

        $sessions = $this->appointmentRepository->getAllSessions($date_from, $date_to, $physician_id, $room_id, $specialization_id, $status);

        return view('appointments.cards')
            ->with('sessions', $sessions);

    }


    public function getCardDetails()
    {

        $session_id = $_POST['session_id'];

        $card_details = $this->appointmentRepository->getSessionDetail($session_id);

        return view('appointments.card_info_table')
            ->with('session' , $card_details);

    }


    public function getBookingDetails()
    {

        $session_id = $_POST['session_id'];

        $booking_details = $this->appointmentRepository->getSessionDetail($session_id);
        $patients = $this->appointmentRepository->getAllPatients();

        return view('appointments.card_booking_table')
            ->with('patients', $patients)
            ->with('session' , $booking_details);

    }

    public function bookAppointments()
    {

        $session_id = $_POST['session_id'];
        $appointment_number = $_POST['appointment_number'];
        $appointment_time = $_POST['appointment_time'];
        $patient_id = $_POST['patient_id'];
        $currency_id = $_POST['currency_id'];
        $amount_per_slot = $_POST['amount_per_slot'];

        return $this->appointmentRepository->bookAppointments($session_id, $appointment_number, $appointment_time, $patient_id, $currency_id, $amount_per_slot);
        
    }


    public function cancelAppointments()
    {

        $session_id = $_POST['session_id'];
        $appointment_number = $_POST['appointment_number'];

        return $this->appointmentRepository->cancelAppointments($session_id, $appointment_number);
        
    }


    public function updatePaymentStatus()
    {

        $appointment_id = $_POST['appointment_id'];
        $paid_at = $_POST['paid_at'];
        $received_by = $_POST['received_by'];

        return $this->appointmentRepository->updatePaymentStatus($appointment_id, $paid_at, $received_by);

    }


    /**
     * Remove the specified Appointment from storage.
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        $appointment = $this->appointmentRepository->find($id);

        $this->storeSessionDetails($id,$appointment->session_id);

        if (empty($appointment)) {
            Flash::error('Appointment not found');

            return redirect(route('appointments.index'));
        }

        $this->appointmentRepository->delete($id);

        Flash::success('Appointment deleted successfully.');

        return redirect(route('appointments.index'));
    }


    /** PUBLIC PORTAL */
    /**
     * Display the specified Appointment.
     *
     * @param int $id
     *
     * @return Response
     */
    public function getAppointmentsPP($id)
    {

        $id = session('phy_session_id');

        $appointments = $this->appointmentRepository->getAppointmentDetails($id);

        $session_details = $this->appointmentRepository->getSessionDetail($id);

        return view('public_portal.physician_session_appointments')
            ->with('session', $session_details)
            ->with('appointments', $appointments);

    }

}
