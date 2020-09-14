<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateSpecializationRequest;
use App\Http\Requests\UpdateSpecializationRequest;
use App\Repositories\SpecializationRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Response;
use Illuminate\Validation\Rule;
use Validator;

class SpecializationController extends AppBaseController
{
    /** @var  SpecializationRepository */
    private $specializationRepository;

    public function __construct(SpecializationRepository $specializationRepo)
    {
        $this->specializationRepository = $specializationRepo;
    }

    /**
     * Display a listing of the Specialization.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function index(Request $request)
    {
        $specializations = $this->specializationRepository->all();

        return view('specializations.index')
            ->with('specializations', $specializations);
    }

    /**
     * Show the form for creating a new Specialization.
     *
     * @return Response
     */
    public function create()
    {
        return view('specializations.create');
    }

    /**
     * Store a newly created Specialization in storage.
     *
     * @param CreateSpecializationRequest $request
     *
     * @return Response
     */
    public function store(CreateSpecializationRequest $request)
    {
        $input = $request->all();

        Validator::make($input, [
            'short_code' => [
                'required',
                Rule::unique('specializations')->where(function ($query) {
                    $query->where('branch_id', session('branch_id'));
                }),
            ],
            'description' => [
                'required',
                Rule::unique('specializations')->where(function ($query) {
                    $query->where('branch_id', session('branch_id'));
                }),
            ],
        ])->validate();

        $specialization = $this->specializationRepository->create($input);

        Flash::success('Specialization saved successfully.');

        return redirect(route('specializations.index'));
    }

    /**
     * Display the specified Specialization.
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $specialization = $this->specializationRepository->find($id);

        if (empty($specialization)) {
            Flash::error('Specialization not found');

            return redirect(route('specializations.index'));
        }

        return view('specializations.show')->with('specialization', $specialization);
    }

    /**
     * Show the form for editing the specified Specialization.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $specialization = $this->specializationRepository->find($id);

        if (empty($specialization)) {
            Flash::error('Specialization not found');

            return redirect(route('specializations.index'));
        }

        return view('specializations.edit')->with('specialization', $specialization);
    }

    /**
     * Update the specified Specialization in storage.
     *
     * @param int $id
     * @param UpdateSpecializationRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateSpecializationRequest $request)
    {
        $specialization = $this->specializationRepository->find($id);

        $input = $request->all();

        Validator::make($input, [
            'short_code' => [
                'required',
                Rule::unique('specializations')->ignore($specialization->id)->where(function ($query) {
                    $query->where('branch_id', session('branch_id'));
                }),
            ],
            'description' => [
                'required',
                Rule::unique('specializations')->ignore($specialization->id)->where(function ($query) {
                    $query->where('branch_id', session('branch_id'));
                }),
            ],
        ])->validate();

        if (empty($specialization)) {
            Flash::error('Specialization not found');

            return redirect(route('specializations.index'));
        }

        $specialization = $this->specializationRepository->update($request->all(), $id);

        Flash::success('Specialization updated successfully.');

        return redirect(route('specializations.index'));
    }

    /**
     * Remove the specified Specialization from storage.
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        $specialization = $this->specializationRepository->find($id);

        if (empty($specialization)) {
            Flash::error('Specialization not found');

            return redirect(route('specializations.index'));
        }

        $this->specializationRepository->delete($id);

        Flash::success('Specialization deleted successfully.');

        return redirect(route('specializations.index'));
    }
}
