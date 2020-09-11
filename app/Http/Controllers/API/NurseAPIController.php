<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateNurseAPIRequest;
use App\Http\Requests\API\UpdateNurseAPIRequest;
use App\Models\Nurse;
use App\Repositories\NurseRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use Response;

/**
 * Class NurseController
 * @package App\Http\Controllers\API
 */

class NurseAPIController extends AppBaseController
{
    /** @var  NurseRepository */
    private $nurseRepository;

    public function __construct(NurseRepository $nurseRepo)
    {
        $this->nurseRepository = $nurseRepo;
    }

    /**
     * Display a listing of the Nurse.
     * GET|HEAD /nurses
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $nurses = $this->nurseRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

        return $this->sendResponse($nurses->toArray(), 'Nurses retrieved successfully');
    }

    /**
     * Store a newly created Nurse in storage.
     * POST /nurses
     *
     * @param CreateNurseAPIRequest $request
     *
     * @return Response
     */
    public function store(CreateNurseAPIRequest $request)
    {
        $input = $request->all();

        $nurse = $this->nurseRepository->create($input);

        return $this->sendResponse($nurse->toArray(), 'Nurse saved successfully');
    }

    /**
     * Display the specified Nurse.
     * GET|HEAD /nurses/{id}
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var Nurse $nurse */
        $nurse = $this->nurseRepository->find($id);

        if (empty($nurse)) {
            return $this->sendError('Nurse not found');
        }

        return $this->sendResponse($nurse->toArray(), 'Nurse retrieved successfully');
    }

    /**
     * Update the specified Nurse in storage.
     * PUT/PATCH /nurses/{id}
     *
     * @param int $id
     * @param UpdateNurseAPIRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateNurseAPIRequest $request)
    {
        $input = $request->all();

        /** @var Nurse $nurse */
        $nurse = $this->nurseRepository->find($id);

        if (empty($nurse)) {
            return $this->sendError('Nurse not found');
        }

        $nurse = $this->nurseRepository->update($input, $id);

        return $this->sendResponse($nurse->toArray(), 'Nurse updated successfully');
    }

    /**
     * Remove the specified Nurse from storage.
     * DELETE /nurses/{id}
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var Nurse $nurse */
        $nurse = $this->nurseRepository->find($id);

        if (empty($nurse)) {
            return $this->sendError('Nurse not found');
        }

        $nurse->delete();

        return $this->sendSuccess('Nurse deleted successfully');
    }
}
