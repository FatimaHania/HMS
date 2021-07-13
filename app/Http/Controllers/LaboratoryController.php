<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateLaboratoryRequest;
use App\Http\Requests\UpdateLaboratoryRequest;
use App\Repositories\LaboratoryRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Response;

class LaboratoryController extends AppBaseController
{
    /** @var  LaboratoryRepository */
    private $laboratoryRepository;

    public function __construct(LaboratoryRepository $laboratoryRepo)
    {
        $this->laboratoryRepository = $laboratoryRepo;
    }

    /**
     * Display a listing of the Laboratory.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function index(Request $request)
    {
        $laboratories = $this->laboratoryRepository->all();

        return view('laboratories.index')
            ->with('laboratories', $laboratories);
    }

    /**
     * Show the form for creating a new Laboratory.
     *
     * @return Response
     */
    public function create()
    {

        $documentCode = $this->laboratoryRepository->documentCode();
        $lastLabRecord = $this->laboratoryRepository->lastLabRecord();

        return view('laboratories.create')
        ->with('documentCode', $documentCode)
        ->with('lastLabRecord', $lastLabRecord);
    }

    /**
     * Store a newly created Laboratory in storage.
     *
     * @param CreateLaboratoryRequest $request
     *
     * @return Response
     */
    public function store(CreateLaboratoryRequest $request)
    {
        $input = $request->all();

        $laboratory = $this->laboratoryRepository->create($input);

        Flash::success('Laboratory saved successfully.');

        return redirect(route('laboratories.index'));
    }

    /**
     * Display the specified Laboratory.
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $laboratory = $this->laboratoryRepository->find($id);

        if (empty($laboratory)) {
            Flash::error('Laboratory not found');

            return redirect(route('laboratories.index'));
        }

        return view('laboratories.show')->with('laboratory', $laboratory);
    }

    /**
     * Show the form for editing the specified Laboratory.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $laboratory = $this->laboratoryRepository->find($id);

        $documentCode = $this->laboratoryRepository->documentCode();
        $lastLabRecord = $this->laboratoryRepository->lastLabRecord();

        if (empty($laboratory)) {
            Flash::error('Laboratory not found');

            return redirect(route('laboratories.index'));
        }

        return view('laboratories.edit')
            ->with('laboratory', $laboratory)
            ->with('documentCode', $documentCode)
            ->with('lastLabRecord', $lastLabRecord);
    }

    /**
     * Update the specified Laboratory in storage.
     *
     * @param int $id
     * @param UpdateLaboratoryRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateLaboratoryRequest $request)
    {
        $laboratory = $this->laboratoryRepository->find($id);

        if (empty($laboratory)) {
            Flash::error('Laboratory not found');

            return redirect(route('laboratories.index'));
        }

        $laboratory = $this->laboratoryRepository->update($request->all(), $id);

        Flash::success('Laboratory updated successfully.');

        return redirect(route('laboratories.index'));
    }

    /**
     * Remove the specified Laboratory from storage.
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        $laboratory = $this->laboratoryRepository->find($id);

        if (empty($laboratory)) {
            Flash::error('Laboratory not found');

            return redirect(route('laboratories.index'));
        }

        $this->laboratoryRepository->delete($id);

        Flash::success('Laboratory deleted successfully.');

        return redirect(route('laboratories.index'));
    }
}
