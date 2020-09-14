<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateTreatmentAPIRequest;
use App\Http\Requests\API\UpdateTreatmentAPIRequest;
use App\Models\Treatment;
use App\Repositories\TreatmentRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use Response;

/**
 * Class TreatmentController
 * @package App\Http\Controllers\API
 */

class TreatmentAPIController extends AppBaseController
{
    /** @var  TreatmentRepository */
    private $treatmentRepository;

    public function __construct(TreatmentRepository $treatmentRepo)
    {
        $this->treatmentRepository = $treatmentRepo;
    }

    /**
     * Display a listing of the Treatment.
     * GET|HEAD /treatments
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $treatments = $this->treatmentRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

        return $this->sendResponse($treatments->toArray(), 'Treatments retrieved successfully');
    }

    /**
     * Store a newly created Treatment in storage.
     * POST /treatments
     *
     * @param CreateTreatmentAPIRequest $request
     *
     * @return Response
     */
    public function store(CreateTreatmentAPIRequest $request)
    {
        $input = $request->all();

        $treatment = $this->treatmentRepository->create($input);

        return $this->sendResponse($treatment->toArray(), 'Treatment saved successfully');
    }

    /**
     * Display the specified Treatment.
     * GET|HEAD /treatments/{id}
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var Treatment $treatment */
        $treatment = $this->treatmentRepository->find($id);

        if (empty($treatment)) {
            return $this->sendError('Treatment not found');
        }

        return $this->sendResponse($treatment->toArray(), 'Treatment retrieved successfully');
    }

    /**
     * Update the specified Treatment in storage.
     * PUT/PATCH /treatments/{id}
     *
     * @param int $id
     * @param UpdateTreatmentAPIRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateTreatmentAPIRequest $request)
    {
        $input = $request->all();

        /** @var Treatment $treatment */
        $treatment = $this->treatmentRepository->find($id);

        if (empty($treatment)) {
            return $this->sendError('Treatment not found');
        }

        $treatment = $this->treatmentRepository->update($input, $id);

        return $this->sendResponse($treatment->toArray(), 'Treatment updated successfully');
    }

    /**
     * Remove the specified Treatment from storage.
     * DELETE /treatments/{id}
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var Treatment $treatment */
        $treatment = $this->treatmentRepository->find($id);

        if (empty($treatment)) {
            return $this->sendError('Treatment not found');
        }

        $treatment->delete();

        return $this->sendSuccess('Treatment deleted successfully');
    }
}
