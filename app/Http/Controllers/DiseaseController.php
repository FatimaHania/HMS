<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateDiseaseRequest;
use App\Http\Requests\UpdateDiseaseRequest;
use App\Repositories\DiseaseRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Response;
use Illuminate\Validation\Rule;
use Validator;

class DiseaseController extends AppBaseController
{
    /** @var  DiseaseRepository */
    private $diseaseRepository;

    public function __construct(DiseaseRepository $diseaseRepo)
    {
        $this->diseaseRepository = $diseaseRepo;
    }

    /**
     * Display a listing of the Disease.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function index(Request $request)
    {
        $diseases = $this->diseaseRepository->all();

        return view('diseases.index')
            ->with('diseases', $diseases);
    }

    /**
     * Show the form for creating a new Disease.
     *
     * @return Response
     */
    public function create()
    {
        return view('diseases.create');
    }

    /**
     * Store a newly created Disease in storage.
     *
     * @param CreateDiseaseRequest $request
     *
     * @return Response
     */
    public function store(CreateDiseaseRequest $request)
    {
        $input = $request->all();

        Validator::make($input, [
            'short_code' => [
                'required',
                Rule::unique('diseases')->where(function ($query) {
                    $query->where('branch_id', session('branch_id'));
                }),
            ],
            'description' => [
                'required',
                Rule::unique('diseases')->where(function ($query) {
                    $query->where('branch_id', session('branch_id'));
                }),
            ],
        ])->validate();

        $disease = $this->diseaseRepository->create($input);

        Flash::success('Disease saved successfully.');

        return redirect(route('diseases.index'));
    }

    /**
     * Display the specified Disease.
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $disease = $this->diseaseRepository->find($id);

        if (empty($disease)) {
            Flash::error('Disease not found');

            return redirect(route('diseases.index'));
        }

        return view('diseases.show')->with('disease', $disease);
    }

    /**
     * Show the form for editing the specified Disease.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $disease = $this->diseaseRepository->find($id);

        if (empty($disease)) {
            Flash::error('Disease not found');

            return redirect(route('diseases.index'));
        }

        return view('diseases.edit')->with('disease', $disease);
    }

    /**
     * Update the specified Disease in storage.
     *
     * @param int $id
     * @param UpdateDiseaseRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateDiseaseRequest $request)
    {
        $disease = $this->diseaseRepository->find($id);

        $input = $request->all();

        Validator::make($input, [
            'short_code' => [
                'required',
                Rule::unique('diseases')->ignore($disease->id)->where(function ($query) {
                    $query->where('branch_id', session('branch_id'));
                }),
            ],
            'description' => [
                'required',
                Rule::unique('diseases')->ignore($disease->id)->where(function ($query) {
                    $query->where('branch_id', session('branch_id'));
                }),
            ],
        ])->validate();

        if (empty($disease)) {
            Flash::error('Disease not found');

            return redirect(route('diseases.index'));
        }

        $disease = $this->diseaseRepository->update($request->all(), $id);

        Flash::success('Disease updated successfully.');

        return redirect(route('diseases.index'));
    }

    /**
     * Remove the specified Disease from storage.
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        $disease = $this->diseaseRepository->find($id);

        if (empty($disease)) {
            Flash::error('Disease not found');

            return redirect(route('diseases.index'));
        }

        $this->diseaseRepository->delete($id);

        Flash::success('Disease deleted successfully.');

        return redirect(route('diseases.index'));
    }
}
