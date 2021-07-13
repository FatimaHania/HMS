<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateCheckupAPIRequest;
use App\Models\Checkup;
use App\Repositories\CheckupRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use Response;

/**
 * Class CheckupController
 * @package App\Http\Controllers\API
 */

class CheckupAPIController extends AppBaseController
{
    /** @var  CheckupRepository */
    private $checkupRepository;

    public function __construct(CheckupRepository $checkupRepo)
    {
        $this->checkupRepository = $checkupRepo;
    }

    /**
     * Display a listing of the Checkup.
     * GET|HEAD /checkups
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $checkups = $this->checkupRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

        return $this->sendResponse($checkups->toArray(), 'Checkups retrieved successfully');
    }

    /**
     * Store a newly created Checkup in storage.
     * POST /checkups
     *
     * @param CreateCheckupAPIRequest $request
     *
     * @return Response
     */
    public function store(CreateCheckupAPIRequest $request)
    {
        $input = $request->all();

        $checkup = $this->checkupRepository->create($input);

        return $this->sendResponse($checkup->toArray(), 'Checkup saved successfully');
    }

    /**
     * Display the specified Checkup.
     * GET|HEAD /checkups/{id}
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var Checkup $checkup */
        $checkup = $this->checkupRepository->find($id);

        if (empty($checkup)) {
            return $this->sendError('Checkup not found');
        }

        return $this->sendResponse($checkup->toArray(), 'Checkup retrieved successfully');
    }


    /**
     * Remove the specified Checkup from storage.
     * DELETE /checkups/{id}
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var Checkup $checkup */
        $checkup = $this->checkupRepository->find($id);

        if (empty($checkup)) {
            return $this->sendError('Checkup not found');
        }

        $checkup->delete();

        return $this->sendSuccess('Checkup deleted successfully');
    }
}
