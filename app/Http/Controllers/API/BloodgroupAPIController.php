<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateBloodgroupAPIRequest;
use App\Http\Requests\API\UpdateBloodgroupAPIRequest;
use App\Models\Bloodgroup;
use App\Repositories\BloodgroupRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use Response;

/**
 * Class BloodgroupController
 * @package App\Http\Controllers\API
 */

class BloodgroupAPIController extends AppBaseController
{
    /** @var  BloodgroupRepository */
    private $bloodgroupRepository;

    public function __construct(BloodgroupRepository $bloodgroupRepo)
    {
        $this->bloodgroupRepository = $bloodgroupRepo;
    }

    /**
     * Display a listing of the Bloodgroup.
     * GET|HEAD /bloodgroups
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $bloodgroups = $this->bloodgroupRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

        return $this->sendResponse($bloodgroups->toArray(), 'Bloodgroups retrieved successfully');
    }

    /**
     * Store a newly created Bloodgroup in storage.
     * POST /bloodgroups
     *
     * @param CreateBloodgroupAPIRequest $request
     *
     * @return Response
     */
    public function store(CreateBloodgroupAPIRequest $request)
    {
        $input = $request->all();

        $bloodgroup = $this->bloodgroupRepository->create($input);

        return $this->sendResponse($bloodgroup->toArray(), 'Bloodgroup saved successfully');
    }

    /**
     * Display the specified Bloodgroup.
     * GET|HEAD /bloodgroups/{id}
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var Bloodgroup $bloodgroup */
        $bloodgroup = $this->bloodgroupRepository->find($id);

        if (empty($bloodgroup)) {
            return $this->sendError('Bloodgroup not found');
        }

        return $this->sendResponse($bloodgroup->toArray(), 'Bloodgroup retrieved successfully');
    }

    /**
     * Update the specified Bloodgroup in storage.
     * PUT/PATCH /bloodgroups/{id}
     *
     * @param int $id
     * @param UpdateBloodgroupAPIRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateBloodgroupAPIRequest $request)
    {
        $input = $request->all();

        /** @var Bloodgroup $bloodgroup */
        $bloodgroup = $this->bloodgroupRepository->find($id);

        if (empty($bloodgroup)) {
            return $this->sendError('Bloodgroup not found');
        }

        $bloodgroup = $this->bloodgroupRepository->update($input, $id);

        return $this->sendResponse($bloodgroup->toArray(), 'Bloodgroup updated successfully');
    }

    /**
     * Remove the specified Bloodgroup from storage.
     * DELETE /bloodgroups/{id}
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var Bloodgroup $bloodgroup */
        $bloodgroup = $this->bloodgroupRepository->find($id);

        if (empty($bloodgroup)) {
            return $this->sendError('Bloodgroup not found');
        }

        $bloodgroup->delete();

        return $this->sendSuccess('Bloodgroup deleted successfully');
    }
}
