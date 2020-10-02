<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateDesignationAPIRequest;
use App\Http\Requests\API\UpdateDesignationAPIRequest;
use App\Models\Designation;
use App\Repositories\DesignationRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use Response;

/**
 * Class DesignationController
 * @package App\Http\Controllers\API
 */

class DesignationAPIController extends AppBaseController
{
    /** @var  DesignationRepository */
    private $designationRepository;

    public function __construct(DesignationRepository $designationRepo)
    {
        $this->designationRepository = $designationRepo;
    }

    /**
     * Display a listing of the Designation.
     * GET|HEAD /designations
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $designations = $this->designationRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

        return $this->sendResponse($designations->toArray(), 'Designations retrieved successfully');
    }

    /**
     * Store a newly created Designation in storage.
     * POST /designations
     *
     * @param CreateDesignationAPIRequest $request
     *
     * @return Response
     */
    public function store(CreateDesignationAPIRequest $request)
    {
        $input = $request->all();

        $designation = $this->designationRepository->create($input);

        return $this->sendResponse($designation->toArray(), 'Designation saved successfully');
    }

    /**
     * Display the specified Designation.
     * GET|HEAD /designations/{id}
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var Designation $designation */
        $designation = $this->designationRepository->find($id);

        if (empty($designation)) {
            return $this->sendError('Designation not found');
        }

        return $this->sendResponse($designation->toArray(), 'Designation retrieved successfully');
    }

    /**
     * Update the specified Designation in storage.
     * PUT/PATCH /designations/{id}
     *
     * @param int $id
     * @param UpdateDesignationAPIRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateDesignationAPIRequest $request)
    {
        $input = $request->all();

        /** @var Designation $designation */
        $designation = $this->designationRepository->find($id);

        if (empty($designation)) {
            return $this->sendError('Designation not found');
        }

        $designation = $this->designationRepository->update($input, $id);

        return $this->sendResponse($designation->toArray(), 'Designation updated successfully');
    }

    /**
     * Remove the specified Designation from storage.
     * DELETE /designations/{id}
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var Designation $designation */
        $designation = $this->designationRepository->find($id);

        if (empty($designation)) {
            return $this->sendError('Designation not found');
        }

        $designation->delete();

        return $this->sendSuccess('Designation deleted successfully');
    }
}
