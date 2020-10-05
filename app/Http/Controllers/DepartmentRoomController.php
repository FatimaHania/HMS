<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateDepartmentRoomRequest;
use App\Http\Requests\UpdateDepartmentRoomRequest;
use App\Repositories\DepartmentRoomRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Response;

use App\Models\Room;

class DepartmentRoomController extends AppBaseController
{
    /** @var  DepartmentRoomRepository */
    private $departmentRoomRepository;

    public function __construct(DepartmentRoomRepository $departmentRoomRepo)
    {
        $this->departmentRoomRepository = $departmentRoomRepo;
    }

    /**
     * Display a listing of the DepartmentRoom.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function index(Request $request)
    {
        $departmentRooms = $this->departmentRoomRepository->all();

        $rooms = Room::all();

        return view('department_rooms.index')
            ->with('rooms', $rooms)
            ->with('departmentRooms', $departmentRooms);
    }

    /**
     * Show the form for creating a new DepartmentRoom.
     *
     * @return Response
     */
    public function create()
    {
        return view('department_rooms.create');
    }

    /**
     * Store a newly created DepartmentRoom in storage.
     *
     * @param CreateDepartmentRoomRequest $request
     *
     * @return Response
     */
    public function store(CreateDepartmentRoomRequest $request)
    {
        $input = $request->all();

        $departmentRoom = $this->departmentRoomRepository->create($input);

        Flash::success('Department Room saved successfully.');

        return redirect(route('departmentRooms.index'));
    }

    /**
     * Display the specified DepartmentRoom.
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $departmentRoom = $this->departmentRoomRepository->find($id);

        if (empty($departmentRoom)) {
            Flash::error('Department Room not found');

            return redirect(route('departmentRooms.index'));
        }

        return view('department_rooms.show')->with('departmentRoom', $departmentRoom);
    }

    /**
     * Show the form for editing the specified DepartmentRoom.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $departmentRoom = $this->departmentRoomRepository->find($id);

        if (empty($departmentRoom)) {
            Flash::error('Department Room not found');

            return redirect(route('departmentRooms.index'));
        }

        return view('department_rooms.edit')->with('departmentRoom', $departmentRoom);
    }

    /**
     * Update the specified DepartmentRoom in storage.
     *
     * @param int $id
     * @param UpdateDepartmentRoomRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateDepartmentRoomRequest $request)
    {
        $departmentRoom = $this->departmentRoomRepository->find($id);

        if (empty($departmentRoom)) {
            Flash::error('Department Room not found');

            return redirect(route('departmentRooms.index'));
        }

        $departmentRoom = $this->departmentRoomRepository->update($request->all(), $id);

        Flash::success('Department Room updated successfully.');

        return redirect(route('departmentRooms.index'));
    }




    /**
     * Display the specified Department Rooms.
     *
     * @return Response
     */
    public function getDepartmentRooms()
    {

        $department_id = $_POST['department_id'];

        $rooms = $this->departmentRoomRepository->getDepartmentRooms($department_id);

        return view('department_rooms.rooms_table')
            ->with('rooms', $rooms);

    }

    /**
     * Remove the specified Departmet Rooms from storage.
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroyDepartmentRooms()
    {

        $department_id = $_POST['department_id'];
        $room_id = $_POST['room_id'];

        return $this->departmentRoomRepository->destroyDepartmentRooms($department_id , $room_id);

    }


    /**
     * Store a newly created Department Room in storage.
     *
     *
     */
    public function storeDepartmentRooms()
    {

        $room_id = $_POST['room_id'];
        $department_id = $_POST['department_id'];

        return $this->departmentRoomRepository->storeDepartmentRooms($department_id , $room_id);
        
    }


    /**
     * Remove the specified DepartmentRoom from storage.
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        $departmentRoom = $this->departmentRoomRepository->find($id);

        if (empty($departmentRoom)) {
            Flash::error('Department Room not found');

            return redirect(route('departmentRooms.index'));
        }

        $this->departmentRoomRepository->delete($id);

        Flash::success('Department Room deleted successfully.');

        return redirect(route('departmentRooms.index'));
    }
}
