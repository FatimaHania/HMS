<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateUsergroupAPIRequest;
use App\Http\Requests\API\UpdateUsergroupAPIRequest;
use App\Models\Usergroup;
use App\Repositories\UsergroupRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use Response;

/**
 * Class UsergroupController
 * @package App\Http\Controllers\API
 */

class UsergroupAPIController extends AppBaseController
{
    /** @var  UsergroupRepository */
    private $usergroupRepository;

    public function __construct(UsergroupRepository $usergroupRepo)
    {
        $this->usergroupRepository = $usergroupRepo;
    }

    /**
     * Display a listing of the Usergroup.
     * GET|HEAD /usergroups
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $usergroups = $this->usergroupRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

        return $this->sendResponse($usergroups->toArray(), 'Usergroups retrieved successfully');
    }

    /**
     * Store a newly created Usergroup in storage.
     * POST /usergroups
     *
     * @param CreateUsergroupAPIRequest $request
     *
     * @return Response
     */
    public function store(CreateUsergroupAPIRequest $request)
    {
        $input = $request->all();

        $usergroup = $this->usergroupRepository->create($input);

        return $this->sendResponse($usergroup->toArray(), 'Usergroup saved successfully');
    }

    /**
     * Display the specified Usergroup.
     * GET|HEAD /usergroups/{id}
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var Usergroup $usergroup */
        $usergroup = $this->usergroupRepository->find($id);

        if (empty($usergroup)) {
            return $this->sendError('Usergroup not found');
        }

        return $this->sendResponse($usergroup->toArray(), 'Usergroup retrieved successfully');
    }

    /**
     * Update the specified Usergroup in storage.
     * PUT/PATCH /usergroups/{id}
     *
     * @param int $id
     * @param UpdateUsergroupAPIRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateUsergroupAPIRequest $request)
    {
        $input = $request->all();

        /** @var Usergroup $usergroup */
        $usergroup = $this->usergroupRepository->find($id);

        if (empty($usergroup)) {
            return $this->sendError('Usergroup not found');
        }

        $usergroup = $this->usergroupRepository->update($input, $id);

        return $this->sendResponse($usergroup->toArray(), 'Usergroup updated successfully');
    }

    /**
     * Remove the specified Usergroup from storage.
     * DELETE /usergroups/{id}
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var Usergroup $usergroup */
        $usergroup = $this->usergroupRepository->find($id);

        if (empty($usergroup)) {
            return $this->sendError('Usergroup not found');
        }

        $usergroup->delete();

        return $this->sendSuccess('Usergroup deleted successfully');
    }
}
