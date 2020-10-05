<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateRoomRequest;
use App\Http\Requests\UpdateRoomRequest;
use App\Repositories\RoomRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Response;

class RoomController extends AppBaseController
{
    /** @var  RoomRepository */
    private $roomRepository;

    public function __construct(RoomRepository $roomRepo)
    {
        $this->roomRepository = $roomRepo;
    }

    /**
     * Display a listing of the Room.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function index(Request $request)
    {
        $rooms = $this->roomRepository->all();

        return view('rooms.index')
            ->with('rooms', $rooms);
    }

    /**
     * Show the form for creating a new Room.
     *
     * @return Response
     */
    public function create()
    {
        return view('rooms.create');
    }

    /**
     * Store a newly created Room in storage.
     *
     * @param CreateRoomRequest $request
     *
     * @return Response
     */
    public function store(CreateRoomRequest $request)
    {
        $input = $request->all();

        $room = $this->roomRepository->create($input);

        Flash::success('Room saved successfully.');

        return redirect(route('rooms.index'));
    }

    /**
     * Display the specified Room.
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $room = $this->roomRepository->find($id);

        if (empty($room)) {
            Flash::error('Room not found');

            return redirect(route('rooms.index'));
        }

        return view('rooms.show')->with('room', $room);
    }

    /**
     * Show the form for editing the specified Room.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $room = $this->roomRepository->find($id);

        if (empty($room)) {
            Flash::error('Room not found');

            return redirect(route('rooms.index'));
        }

        return view('rooms.edit')->with('room', $room);
    }

    /**
     * Update the specified Room in storage.
     *
     * @param int $id
     * @param UpdateRoomRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateRoomRequest $request)
    {
        $room = $this->roomRepository->find($id);

        if (empty($room)) {
            Flash::error('Room not found');

            return redirect(route('rooms.index'));
        }

        $room = $this->roomRepository->update($request->all(), $id);

        Flash::success('Room updated successfully.');

        return redirect(route('rooms.index'));
    }

    /**
     * Remove the specified Room from storage.
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        $room = $this->roomRepository->find($id);

        if (empty($room)) {
            Flash::error('Room not found');

            return redirect(route('rooms.index'));
        }

        $this->roomRepository->delete($id);

        Flash::success('Room deleted successfully.');

        return redirect(route('rooms.index'));
    }
}
