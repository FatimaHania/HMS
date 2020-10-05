<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateDepartmentRoomAPIRequest;
use App\Http\Requests\API\UpdateDepartmentRoomAPIRequest;
use App\Models\DepartmentRoom;
use App\Repositories\DepartmentRoomRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use Response;

/**
 * Class DepartmentRoomController
 * @package App\Http\Controllers\API
 */

class DepartmentRoomAPIController extends AppBaseController
{
    /** @var  DepartmentRoomRepository */
    private $departmentRoomRepository;

    public function __construct(DepartmentRoomRepository $departmentRoomRepo)
    {
        $this->departmentRoomRepository = $departmentRoomRepo;
    }

    /**
     * Display a listing of the DepartmentRoom.
     * GET|HEAD /departmentRooms
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $departmentRooms = $this->departmentRoomRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

        return $this->sendResponse($departmentRooms->toArray(), 'Department Rooms retrieved successfully');
    }

    /**
     * Store a newly created DepartmentRoom in storage.
     * POST /departmentRooms
     *
     * @param CreateDepartmentRoomAPIRequest $request
     *
     * @return Response
     */
    public function store(CreateDepartmentRoomAPIRequest $request)
    {
        $input = $request->all();

        $departmentRoom = $this->departmentRoomRepository->create($input);

        return $this->sendResponse($departmentRoom->toArray(), 'Department Room saved successfully');
    }

    /**
     * Display the specified DepartmentRoom.
     * GET|HEAD /departmentRooms/{id}
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var DepartmentRoom $departmentRoom */
        $departmentRoom = $this->departmentRoomRepository->find($id);

        if (empty($departmentRoom)) {
            return $this->sendError('Department Room not found');
        }

        return $this->sendResponse($departmentRoom->toArray(), 'Department Room retrieved successfully');
    }

    /**
     * Update the specified DepartmentRoom in storage.
     * PUT/PATCH /departmentRooms/{id}
     *
     * @param int $id
     * @param UpdateDepartmentRoomAPIRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateDepartmentRoomAPIRequest $request)
    {
        $input = $request->all();

        /** @var DepartmentRoom $departmentRoom */
        $departmentRoom = $this->departmentRoomRepository->find($id);

        if (empty($departmentRoom)) {
            return $this->sendError('Department Room not found');
        }

        $departmentRoom = $this->departmentRoomRepository->update($input, $id);

        return $this->sendResponse($departmentRoom->toArray(), 'DepartmentRoom updated successfully');
    }

    /**
     * Remove the specified DepartmentRoom from storage.
     * DELETE /departmentRooms/{id}
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var DepartmentRoom $departmentRoom */
        $departmentRoom = $this->departmentRoomRepository->find($id);

        if (empty($departmentRoom)) {
            return $this->sendError('Department Room not found');
        }

        $departmentRoom->delete();

        return $this->sendSuccess('Department Room deleted successfully');
    }
}
