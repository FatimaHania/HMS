<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreatePhysicianAPIRequest;
use App\Http\Requests\API\UpdatePhysicianAPIRequest;
use App\Models\Physician;
use App\Repositories\PhysicianRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use Response;

/**
 * Class PhysicianController
 * @package App\Http\Controllers\API
 */

class PhysicianAPIController extends AppBaseController
{
    /** @var  PhysicianRepository */
    private $physicianRepository;

    public function __construct(PhysicianRepository $physicianRepo)
    {
        $this->physicianRepository = $physicianRepo;
    }

    /**
     * Display a listing of the Physician.
     * GET|HEAD /physicians
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $physicians = $this->physicianRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

        return $this->sendResponse($physicians->toArray(), 'Physicians retrieved successfully');
    }

    /**
     * Store a newly created Physician in storage.
     * POST /physicians
     *
     * @param CreatePhysicianAPIRequest $request
     *
     * @return Response
     */
    public function store(CreatePhysicianAPIRequest $request)
    {
        $input = $request->all();

        $physician = $this->physicianRepository->create($input);

        return $this->sendResponse($physician->toArray(), 'Physician saved successfully');
    }

    /**
     * Display the specified Physician.
     * GET|HEAD /physicians/{id}
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var Physician $physician */
        $physician = $this->physicianRepository->find($id);

        if (empty($physician)) {
            return $this->sendError('Physician not found');
        }

        return $this->sendResponse($physician->toArray(), 'Physician retrieved successfully');
    }

    /**
     * Update the specified Physician in storage.
     * PUT/PATCH /physicians/{id}
     *
     * @param int $id
     * @param UpdatePhysicianAPIRequest $request
     *
     * @return Response
     */
    public function update($id, UpdatePhysicianAPIRequest $request)
    {
        $input = $request->all();

        /** @var Physician $physician */
        $physician = $this->physicianRepository->find($id);

        if (empty($physician)) {
            return $this->sendError('Physician not found');
        }

        $physician = $this->physicianRepository->update($input, $id);

        return $this->sendResponse($physician->toArray(), 'Physician updated successfully');
    }

    /**
     * Remove the specified Physician from storage.
     * DELETE /physicians/{id}
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var Physician $physician */
        $physician = $this->physicianRepository->find($id);

        if (empty($physician)) {
            return $this->sendError('Physician not found');
        }

        $physician->delete();

        return $this->sendSuccess('Physician deleted successfully');
    }
}
