<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreatePatientRequest;
use App\Http\Requests\UpdatePatientRequest;
use App\Repositories\PatientRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Response;
use Illuminate\Validation\Rule;
use Validator;

use App\Models\Patient;
use App\Models\Title;
use App\Models\Gender;
use App\Models\Country;
use App\Models\Nationality;
use App\Models\Bloodgroup;
use App\Models\DocumentCode;

class PatientController extends AppBaseController
{
    /** @var  PatientRepository */
    private $patientRepository;

    public function __construct(PatientRepository $patientRepo)
    {
        $this->patientRepository = $patientRepo;
    }

    /**
     * Display a listing of the Patient.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function index(Request $request)
    {
        $patients = $this->patientRepository->getAll();

        return view('patients.index')
            ->with('patients', $patients);
    }

    /**
     * Show the form for creating a new Patient.
     *
     * @return Response
     */
    public function create()
    {
        
        $titles = Title::where('branch_id' , session('branch_id'))->pluck('short_code' , 'id');
        $genders = Gender::where('branch_id' , session('branch_id'))->pluck('description' , 'id');
        $countries = Country::where('branch_id' , session('branch_id'))->pluck('description' , 'id');
        $nationalities = Nationality::where('branch_id' , session('branch_id'))->pluck('description' , 'id');
        $bloodgroups = Bloodgroup::where('branch_id' , session('branch_id'))->pluck('short_code' , 'id');
        $documentCode = DocumentCode::where([['documentcode_id' , 1] , ['branch_id' , session('branch_id')]])->first();
        $lastPatientRecord = Patient::where('branch_id' , session('branch_id'))->orderBy('patient_number', 'DESC')->first();

        return view('patients.create')
        ->with('titles', $titles)
        ->with('genders', $genders)
        ->with('countries', $countries)
        ->with('nationalities', $nationalities)
        ->with('bloodgroups', $bloodgroups)
        ->with('documentCode', $documentCode)
        ->with('lastPatientRecord', $lastPatientRecord);
    }

    /**
     * Store a newly created Patient in storage.
     *
     * @param CreatePatientRequest $request
     *
     * @return Response
     */
    public function store(CreatePatientRequest $request)
    {
        $input = $request->all();

        Validator::make($input, [
            'patient_code' => [
                'required',
                Rule::unique('patients')->where(function ($query) {
                    $query->where('branch_id', session('branch_id'));
                }),
            ],
        ])->validate();

        if(request('patient_image_upload')) {

            $input['patient_image'] = request('patient_image_upload')->storeAs('images/patients' , 'PNT-'.session('hospital_id').session('branch_id').'-'.$input['patient_code'].'.'.($request->patient_image_upload->extension()));

        }

        $patient = $this->patientRepository->create($input);

        Flash::success('Patient saved successfully.');

        return redirect(route('patients.index'));
    }

    /**
     * Display the specified Patient.
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $patient = $this->patientRepository->find($id);

        if (empty($patient)) {
            Flash::error('Patient not found');

            return redirect(route('patients.index'));
        }

        return view('patients.show')->with('patient', $patient);
    }

    /**
     * Show the form for editing the specified Patient.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit($id)
    {

        $patient = $this->patientRepository->find($id);

        $titles = Title::where('branch_id' , session('branch_id'))->pluck('short_code' , 'id');
        $genders = Gender::where('branch_id' , session('branch_id'))->pluck('short_code' , 'id');
        $countries = Country::where('branch_id' , session('branch_id'))->pluck('short_code' , 'id');
        $nationalities = Nationality::where('branch_id' , session('branch_id'))->pluck('short_code' , 'id');
        $bloodgroups = Bloodgroup::where('branch_id' , session('branch_id'))->pluck('short_code' , 'id');
        $documentCode = DocumentCode::where([['documentcode_id' , 1] , ['branch_id' , session('branch_id')]])->first();
        $lastPatientRecord = Patient::where('branch_id' , session('branch_id'))->orderBy('patient_number', 'DESC')->first();
        
        if (empty($patient)) {
            Flash::error('Patient not found');

            return redirect(route('patients.index'));
        }

        return view('patients.edit')
        ->with('patient', $patient)
        ->with('titles', $titles)
        ->with('genders', $genders)
        ->with('countries', $countries)
        ->with('nationalities', $nationalities)
        ->with('bloodgroups', $bloodgroups)
        ->with('documentCode', $documentCode)
        ->with('lastPatientRecord', $lastPatientRecord);
    }

    /**
     * Update the specified Patient in storage.
     *
     * @param int $id
     * @param UpdatePatientRequest $request
     *
     * @return Response
     */
    public function update($id, UpdatePatientRequest $request)
    {
        $patient = $this->patientRepository->find($id);

        $input = $request->all();

        Validator::make($input, [
            'patient_code' => [
                'required',
                Rule::unique('patients')->ignore($patient->id)->where(function ($query) {
                    $query->where('branch_id', session('branch_id'));
                }),
            ],
        ])->validate();

        if (empty($patient)) {
            Flash::error('Patient not found');

            return redirect(route('patients.index'));
        }

        if(request('patient_image_upload')) {

            $input['patient_image'] = request('patient_image_upload')->storeAs('images/patients' , 'PNT-'.session('hospital_id').session('branch_id').'-'.$input['patient_code'].'.'.($request->patient_image_upload->extension()));

        }

        $patient = $this->patientRepository->update($input, $id);

        Flash::success('Patient updated successfully.');

        return redirect(route('patients.index'));
    }

    /**
     * Remove the specified Patient from storage.
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        $patient = $this->patientRepository->find($id);

        if (empty($patient)) {
            Flash::error('Patient not found');

            return redirect(route('patients.index'));
        }

        $this->patientRepository->delete($id);

        Flash::success('Patient deleted successfully.');

        return redirect(route('patients.index'));
    }
}
