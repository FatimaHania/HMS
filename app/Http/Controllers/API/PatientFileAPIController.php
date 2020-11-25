<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreatePatientFileAPIRequest;
use App\Http\Requests\API\UpdatePatientFileAPIRequest;
use App\Models\PatientFile;
use App\Repositories\PatientFileRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use Response;

/**
 * Class PatientFileController
 * @package App\Http\Controllers\API
 */

class PatientFileAPIController extends AppBaseController
{
    /** @var  PatientFileRepository */
    private $patientFileRepository;

    public function __construct(PatientFileRepository $patientFileRepo)
    {
        $this->patientFileRepository = $patientFileRepo;
    }

    /**
     * Display a listing of the PatientFile.
     * GET|HEAD /patientFiles
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $patientFiles = $this->patientFileRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

        return $this->sendResponse($patientFiles->toArray(), 'Patient Files retrieved successfully');
    }

    /**
     * Store a newly created PatientFile in storage.
     * POST /patientFiles
     *
     * @param CreatePatientFileAPIRequest $request
     *
     * @return Response
     */
    public function store(CreatePatientFileAPIRequest $request)
    {
        $input = $request->all();

        $patientFile = $this->patientFileRepository->create($input);

        return $this->sendResponse($patientFile->toArray(), 'Patient File saved successfully');
    }

    /**
     * Display the specified PatientFile.
     * GET|HEAD /patientFiles/{id}
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var PatientFile $patientFile */
        $patientFile = $this->patientFileRepository->find($id);

        if (empty($patientFile)) {
            return $this->sendError('Patient File not found');
        }

        return $this->sendResponse($patientFile->toArray(), 'Patient File retrieved successfully');
    }

    /**
     * Update the specified PatientFile in storage.
     * PUT/PATCH /patientFiles/{id}
     *
     * @param int $id
     * @param UpdatePatientFileAPIRequest $request
     *
     * @return Response
     */
    public function update($id, UpdatePatientFileAPIRequest $request)
    {
        $input = $request->all();

        /** @var PatientFile $patientFile */
        $patientFile = $this->patientFileRepository->find($id);

        if (empty($patientFile)) {
            return $this->sendError('Patient File not found');
        }

        $patientFile = $this->patientFileRepository->update($input, $id);

        return $this->sendResponse($patientFile->toArray(), 'PatientFile updated successfully');
    }

    /**
     * Remove the specified PatientFile from storage.
     * DELETE /patientFiles/{id}
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var PatientFile $patientFile */
        $patientFile = $this->patientFileRepository->find($id);

        if (empty($patientFile)) {
            return $this->sendError('Patient File not found');
        }

        $patientFile->delete();

        return $this->sendSuccess('Patient File deleted successfully');
    }
}
