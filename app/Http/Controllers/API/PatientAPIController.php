<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreatePatientAPIRequest;
use App\Http\Requests\API\UpdatePatientAPIRequest;
use App\Models\Patient;
use App\Repositories\PatientRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use Response;

/**
 * Class PatientController
 * @package App\Http\Controllers\API
 */

class PatientAPIController extends AppBaseController
{
    /** @var  PatientRepository */
    private $patientRepository;

    public function __construct(PatientRepository $patientRepo)
    {
        $this->patientRepository = $patientRepo;
    }

    /**
     * Display a listing of the Patient.
     * GET|HEAD /patients
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $patients = $this->patientRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

        return $this->sendResponse($patients->toArray(), 'Patients retrieved successfully');
    }

    /**
     * Store a newly created Patient in storage.
     * POST /patients
     *
     * @param CreatePatientAPIRequest $request
     *
     * @return Response
     */
    public function store(CreatePatientAPIRequest $request)
    {
        $input = $request->all();

        $patient = $this->patientRepository->create($input);

        return $this->sendResponse($patient->toArray(), 'Patient saved successfully');
    }

    /**
     * Display the specified Patient.
     * GET|HEAD /patients/{id}
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var Patient $patient */
        $patient = $this->patientRepository->find($id);

        if (empty($patient)) {
            return $this->sendError('Patient not found');
        }

        return $this->sendResponse($patient->toArray(), 'Patient retrieved successfully');
    }

    /**
     * Update the specified Patient in storage.
     * PUT/PATCH /patients/{id}
     *
     * @param int $id
     * @param UpdatePatientAPIRequest $request
     *
     * @return Response
     */
    public function update($id, UpdatePatientAPIRequest $request)
    {
        $input = $request->all();

        /** @var Patient $patient */
        $patient = $this->patientRepository->find($id);

        if (empty($patient)) {
            return $this->sendError('Patient not found');
        }

        $patient = $this->patientRepository->update($input, $id);

        return $this->sendResponse($patient->toArray(), 'Patient updated successfully');
    }

    /**
     * Remove the specified Patient from storage.
     * DELETE /patients/{id}
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var Patient $patient */
        $patient = $this->patientRepository->find($id);

        if (empty($patient)) {
            return $this->sendError('Patient not found');
        }

        $patient->delete();

        return $this->sendSuccess('Patient deleted successfully');
    }
}
