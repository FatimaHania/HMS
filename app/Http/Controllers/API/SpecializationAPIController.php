<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateSpecializationAPIRequest;
use App\Http\Requests\API\UpdateSpecializationAPIRequest;
use App\Models\Specialization;
use App\Repositories\SpecializationRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use Response;

/**
 * Class SpecializationController
 * @package App\Http\Controllers\API
 */

class SpecializationAPIController extends AppBaseController
{
    /** @var  SpecializationRepository */
    private $specializationRepository;

    public function __construct(SpecializationRepository $specializationRepo)
    {
        $this->specializationRepository = $specializationRepo;
    }

    /**
     * Display a listing of the Specialization.
     * GET|HEAD /specializations
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $specializations = $this->specializationRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

        return $this->sendResponse($specializations->toArray(), 'Specializations retrieved successfully');
    }

    /**
     * Store a newly created Specialization in storage.
     * POST /specializations
     *
     * @param CreateSpecializationAPIRequest $request
     *
     * @return Response
     */
    public function store(CreateSpecializationAPIRequest $request)
    {
        $input = $request->all();

        $specialization = $this->specializationRepository->create($input);

        return $this->sendResponse($specialization->toArray(), 'Specialization saved successfully');
    }

    /**
     * Display the specified Specialization.
     * GET|HEAD /specializations/{id}
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var Specialization $specialization */
        $specialization = $this->specializationRepository->find($id);

        if (empty($specialization)) {
            return $this->sendError('Specialization not found');
        }

        return $this->sendResponse($specialization->toArray(), 'Specialization retrieved successfully');
    }

    /**
     * Update the specified Specialization in storage.
     * PUT/PATCH /specializations/{id}
     *
     * @param int $id
     * @param UpdateSpecializationAPIRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateSpecializationAPIRequest $request)
    {
        $input = $request->all();

        /** @var Specialization $specialization */
        $specialization = $this->specializationRepository->find($id);

        if (empty($specialization)) {
            return $this->sendError('Specialization not found');
        }

        $specialization = $this->specializationRepository->update($input, $id);

        return $this->sendResponse($specialization->toArray(), 'Specialization updated successfully');
    }

    /**
     * Remove the specified Specialization from storage.
     * DELETE /specializations/{id}
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var Specialization $specialization */
        $specialization = $this->specializationRepository->find($id);

        if (empty($specialization)) {
            return $this->sendError('Specialization not found');
        }

        $specialization->delete();

        return $this->sendSuccess('Specialization deleted successfully');
    }
}
