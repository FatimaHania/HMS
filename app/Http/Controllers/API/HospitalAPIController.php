<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateHospitalAPIRequest;
use App\Http\Requests\API\UpdateHospitalAPIRequest;
use App\Models\Hospital;
use App\Repositories\HospitalRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use Response;

/**
 * Class HospitalController
 * @package App\Http\Controllers\API
 */

class HospitalAPIController extends AppBaseController
{
    /** @var  HospitalRepository */
    private $hospitalRepository;

    public function __construct(HospitalRepository $hospitalRepo)
    {
        $this->hospitalRepository = $hospitalRepo;
    }

    /**
     * Display a listing of the Hospital.
     * GET|HEAD /hospitals
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $hospitals = $this->hospitalRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

        return $this->sendResponse($hospitals->toArray(), 'Hospitals retrieved successfully');
    }

    /**
     * Store a newly created Hospital in storage.
     * POST /hospitals
     *
     * @param CreateHospitalAPIRequest $request
     *
     * @return Response
     */
    public function store(CreateHospitalAPIRequest $request)
    {
        $input = $request->all();

        $hospital = $this->hospitalRepository->create($input);

        return $this->sendResponse($hospital->toArray(), 'Hospital saved successfully');
    }

    /**
     * Display the specified Hospital.
     * GET|HEAD /hospitals/{id}
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var Hospital $hospital */
        $hospital = $this->hospitalRepository->find($id);

        if (empty($hospital)) {
            return $this->sendError('Hospital not found');
        }

        return $this->sendResponse($hospital->toArray(), 'Hospital retrieved successfully');
    }

    /**
     * Update the specified Hospital in storage.
     * PUT/PATCH /hospitals/{id}
     *
     * @param int $id
     * @param UpdateHospitalAPIRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateHospitalAPIRequest $request)
    {
        $input = $request->all();

        /** @var Hospital $hospital */
        $hospital = $this->hospitalRepository->find($id);

        if (empty($hospital)) {
            return $this->sendError('Hospital not found');
        }

        $hospital = $this->hospitalRepository->update($input, $id);

        return $this->sendResponse($hospital->toArray(), 'Hospital updated successfully');
    }

    /**
     * Remove the specified Hospital from storage.
     * DELETE /hospitals/{id}
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var Hospital $hospital */
        $hospital = $this->hospitalRepository->find($id);

        if (empty($hospital)) {
            return $this->sendError('Hospital not found');
        }

        $hospital->delete();

        return $this->sendSuccess('Hospital deleted successfully');
    }
}
