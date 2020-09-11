<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateHospitalRequest;
use App\Http\Requests\UpdateHospitalRequest;
use App\Repositories\HospitalRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Response;

class HospitalController extends AppBaseController
{
    /** @var  HospitalRepository */
    private $hospitalRepository;

    public function __construct(HospitalRepository $hospitalRepo)
    {
        $this->hospitalRepository = $hospitalRepo;
    }

    /**
     * Display a listing of the Hospital.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function index(Request $request)
    {
        $hospitals = $this->hospitalRepository->getHospital();

        return view('hospitals.index')
            ->with('hospitals', $hospitals);
    }

    /**
     * Show the form for creating a new Hospital.
     *
     * @return Response
     */
    public function create()
    {
        return view('hospitals.create');
    }

    /**
     * Store a newly created Hospital in storage.
     *
     * @param CreateHospitalRequest $request
     *
     * @return Response
     */
    public function store(CreateHospitalRequest $request)
    {
        $input = $request->all();

        $hospital = $this->hospitalRepository->create($input);

        Flash::success('Hospital saved successfully.');

        return redirect(route('hospitals.index'));
    }

    /**
     * Display the specified Hospital.
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $hospital = $this->hospitalRepository->find($id);

        if (empty($hospital)) {
            Flash::error('Hospital not found');

            return redirect(route('hospitals.index'));
        }

        return view('hospitals.show')->with('hospital', $hospital);
    }

    /**
     * Show the form for editing the specified Hospital.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $hospital = $this->hospitalRepository->find($id);

        if (empty($hospital)) {
            Flash::error('Hospital not found');

            return redirect(route('hospitals.index'));
        }

        return view('hospitals.edit')->with('hospital', $hospital);
    }

    /**
     * Update the specified Hospital in storage.
     *
     * @param int $id
     * @param UpdateHospitalRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateHospitalRequest $request)
    {
        $hospital = $this->hospitalRepository->find($id);

        if (empty($hospital)) {
            Flash::error('Hospital not found');

            return redirect(route('hospitals.index'));
        }

        $input = $request->all();

        if(request('logo_upload')) {

            $input['logo'] = request('logo_upload')->storeAs('images' , 'LOGO-'.session('hospital_id').session('branch_id').'-'.$input['short_code'].'.'.($request->logo_upload->extension()));

        }

        $hospital = $this->hospitalRepository->update($input, $id);

        Flash::success('Hospital updated successfully.');

        return redirect(route('hospitals.index'));
    }

    /**
     * Remove the specified Hospital from storage.
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        $hospital = $this->hospitalRepository->find($id);

        if (empty($hospital)) {
            Flash::error('Hospital not found');

            return redirect(route('hospitals.index'));
        }

        $this->hospitalRepository->delete($id);

        Flash::success('Hospital deleted successfully.');

        return redirect(route('hospitals.index'));
    }
}
