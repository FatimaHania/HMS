<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreatePatientFileRequest;
use App\Http\Requests\UpdatePatientFileRequest;
use App\Repositories\PatientFileRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Response;
use Illuminate\Validation\Rule;
use Validator;

class PatientFileController extends AppBaseController
{
    /** @var  PatientFileRepository */
    private $patientFileRepository;

    public function __construct(PatientFileRepository $patientFileRepo)
    {
        $this->patientFileRepository = $patientFileRepo;
    }

    public function storeSessionDetails($editedPatientId)
    {

        session()->flash('editedPatientId', $editedPatientId);

    }

    /**
     * Display a listing of the PatientFile.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function index(Request $request)
    {

        $patientFiles = $this->patientFileRepository->getAll();

        $patients = $this->patientFileRepository->getPatients();
        $departments = $this->patientFileRepository->getDepartments();
        $diseases = $this->patientFileRepository->getDiseases();

        return view('patient_files.index')
            ->with('patientFiles', $patientFiles)
            ->with('patients', $patients)
            ->with('departments', $departments)
            ->with('diseases', $diseases);
    }

    /**
     * Show the form for creating a new PatientFile.
     *
     * @return Response
     */
    public function create()
    {

        $patients = $this->patientFileRepository->getPatients();
        $departments = $this->patientFileRepository->getDepartments();
        $diseases = $this->patientFileRepository->getDiseases();

        return view('patient_files.create')
            ->with('patients', $patients)
            ->with('departments', $departments)
            ->with('diseases', $diseases);
    }

    /**
     * Store a newly created PatientFile in storage.
     *
     * @param CreatePatientFileRequest $request
     *
     * @return Response
     */
    public function store(CreatePatientFileRequest $request)
    {
        $input = $request->all();

        $patientFile = $this->patientFileRepository->create($input);

        Flash::success('Patient File saved successfully.');

        return redirect(route('patientFiles.index'));
    }

    /**
     * Display the specified PatientFile.
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $patientFile = $this->patientFileRepository->find($id);

        if (empty($patientFile)) {
            Flash::error('Patient File not found');

            return redirect(route('patientFiles.index'));
        }

        $this->storeSessionDetails($patientFile->patient_id);

        return view('patient_files.show')->with('patientFile', $patientFile);
    }

    /**
     * Show the form for editing the specified PatientFile.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $patientFile = $this->patientFileRepository->find($id);

        if (empty($patientFile)) {
            Flash::error('Patient File not found');

            return redirect(route('patientFiles.index'));
        }

        $patients = $this->patientFileRepository->getPatients();
        $departments = $this->patientFileRepository->getDepartments();
        $diseases = $this->patientFileRepository->getDiseases();

        $this->storeSessionDetails($patientFile->patient_id);

        return view('patient_files.edit')
            ->with('patientFile', $patientFile)
            ->with('patients', $patients)
            ->with('departments', $departments)
            ->with('diseases', $diseases);
    }

    /**
     * Update the specified PatientFile in storage.
     *
     * @param int $id
     * @param UpdatePatientFileRequest $request
     *
     * @return Response
     */
    public function update($id, UpdatePatientFileRequest $request)
    {
        $patientFile = $this->patientFileRepository->find($id);

        if (empty($patientFile)) {
            Flash::error('Patient File not found');

            return redirect(route('patientFiles.index'));
        }

        $this->storeSessionDetails($patientFile->patient_id);

        $patientFile = $this->patientFileRepository->update($request->all(), $id);

        Flash::success('Patient File updated successfully.');

        return redirect(route('patientFiles.index'));
    }

    public function getPatientFiles()
    {

        $patientId = $_POST['patientId'];

        $patientFiles = $this->patientFileRepository->getPatientFiles($patientId);

        return view('patient_files.table')
            ->with('patientFiles', $patientFiles);

    }


    /**
     * Remove the specified PatientFile from storage.
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        $patientFile = $this->patientFileRepository->find($id);

        if (empty($patientFile)) {
            Flash::error('Patient File not found');

            return redirect(route('patientFiles.index'));
        }

        $this->patientFileRepository->delete($id);

        Flash::success('Patient File deleted successfully.');

        return redirect(route('patientFiles.index'));
    }
}
