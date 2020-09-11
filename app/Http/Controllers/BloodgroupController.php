<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateBloodgroupRequest;
use App\Http\Requests\UpdateBloodgroupRequest;
use App\Repositories\BloodgroupRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Response;

class BloodgroupController extends AppBaseController
{
    /** @var  BloodgroupRepository */
    private $bloodgroupRepository;

    public function __construct(BloodgroupRepository $bloodgroupRepo)
    {
        $this->bloodgroupRepository = $bloodgroupRepo;
    }

    /**
     * Display a listing of the Bloodgroup.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function index(Request $request)
    {
        $bloodgroups = $this->bloodgroupRepository->all();

        return view('bloodgroups.index')
            ->with('bloodgroups', $bloodgroups);
    }

    /**
     * Show the form for creating a new Bloodgroup.
     *
     * @return Response
     */
    public function create()
    {
        return view('bloodgroups.create');
    }

    /**
     * Store a newly created Bloodgroup in storage.
     *
     * @param CreateBloodgroupRequest $request
     *
     * @return Response
     */
    public function store(CreateBloodgroupRequest $request)
    {
        $input = $request->all();

        $bloodgroup = $this->bloodgroupRepository->create($input);

        Flash::success('Bloodgroup saved successfully.');

        return redirect(route('bloodgroups.index'));
    }

    /**
     * Display the specified Bloodgroup.
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $bloodgroup = $this->bloodgroupRepository->find($id);

        if (empty($bloodgroup)) {
            Flash::error('Bloodgroup not found');

            return redirect(route('bloodgroups.index'));
        }

        return view('bloodgroups.show')->with('bloodgroup', $bloodgroup);
    }

    /**
     * Show the form for editing the specified Bloodgroup.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $bloodgroup = $this->bloodgroupRepository->find($id);

        if (empty($bloodgroup)) {
            Flash::error('Bloodgroup not found');

            return redirect(route('bloodgroups.index'));
        }

        return view('bloodgroups.edit')->with('bloodgroup', $bloodgroup);
    }

    /**
     * Update the specified Bloodgroup in storage.
     *
     * @param int $id
     * @param UpdateBloodgroupRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateBloodgroupRequest $request)
    {
        $bloodgroup = $this->bloodgroupRepository->find($id);

        if (empty($bloodgroup)) {
            Flash::error('Bloodgroup not found');

            return redirect(route('bloodgroups.index'));
        }

        $bloodgroup = $this->bloodgroupRepository->update($request->all(), $id);

        Flash::success('Bloodgroup updated successfully.');

        return redirect(route('bloodgroups.index'));
    }

    /**
     * Remove the specified Bloodgroup from storage.
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        $bloodgroup = $this->bloodgroupRepository->find($id);

        if (empty($bloodgroup)) {
            Flash::error('Bloodgroup not found');

            return redirect(route('bloodgroups.index'));
        }

        $this->bloodgroupRepository->delete($id);

        Flash::success('Bloodgroup deleted successfully.');

        return redirect(route('bloodgroups.index'));
    }
}
