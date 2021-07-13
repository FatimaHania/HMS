<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateLaboratoryAPIRequest;
use App\Http\Requests\API\UpdateLaboratoryAPIRequest;
use App\Models\Laboratory;
use App\Repositories\LaboratoryRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use Response;

/**
 * Class LaboratoryController
 * @package App\Http\Controllers\API
 */

class LaboratoryAPIController extends AppBaseController
{
    /** @var  LaboratoryRepository */
    private $laboratoryRepository;

    public function __construct(LaboratoryRepository $laboratoryRepo)
    {
        $this->laboratoryRepository = $laboratoryRepo;
    }

    /**
     * Display a listing of the Laboratory.
     * GET|HEAD /laboratories
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $laboratories = $this->laboratoryRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

        return $this->sendResponse($laboratories->toArray(), 'Laboratories retrieved successfully');
    }

    /**
     * Store a newly created Laboratory in storage.
     * POST /laboratories
     *
     * @param CreateLaboratoryAPIRequest $request
     *
     * @return Response
     */
    public function store(CreateLaboratoryAPIRequest $request)
    {
        $input = $request->all();

        $laboratory = $this->laboratoryRepository->create($input);

        return $this->sendResponse($laboratory->toArray(), 'Laboratory saved successfully');
    }

    /**
     * Display the specified Laboratory.
     * GET|HEAD /laboratories/{id}
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var Laboratory $laboratory */
        $laboratory = $this->laboratoryRepository->find($id);

        if (empty($laboratory)) {
            return $this->sendError('Laboratory not found');
        }

        return $this->sendResponse($laboratory->toArray(), 'Laboratory retrieved successfully');
    }

    /**
     * Update the specified Laboratory in storage.
     * PUT/PATCH /laboratories/{id}
     *
     * @param int $id
     * @param UpdateLaboratoryAPIRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateLaboratoryAPIRequest $request)
    {
        $input = $request->all();

        /** @var Laboratory $laboratory */
        $laboratory = $this->laboratoryRepository->find($id);

        if (empty($laboratory)) {
            return $this->sendError('Laboratory not found');
        }

        $laboratory = $this->laboratoryRepository->update($input, $id);

        return $this->sendResponse($laboratory->toArray(), 'Laboratory updated successfully');
    }

    /**
     * Remove the specified Laboratory from storage.
     * DELETE /laboratories/{id}
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var Laboratory $laboratory */
        $laboratory = $this->laboratoryRepository->find($id);

        if (empty($laboratory)) {
            return $this->sendError('Laboratory not found');
        }

        $laboratory->delete();

        return $this->sendSuccess('Laboratory deleted successfully');
    }
}
