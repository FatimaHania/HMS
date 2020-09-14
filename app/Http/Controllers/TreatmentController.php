<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateTreatmentRequest;
use App\Http\Requests\UpdateTreatmentRequest;
use App\Repositories\TreatmentRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Response;
use Illuminate\Validation\Rule;
use Validator;

class TreatmentController extends AppBaseController
{
    /** @var  TreatmentRepository */
    private $treatmentRepository;

    public function __construct(TreatmentRepository $treatmentRepo)
    {
        $this->treatmentRepository = $treatmentRepo;
    }

    /**
     * Display a listing of the Treatment.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function index(Request $request)
    {
        $treatments = $this->treatmentRepository->all();

        return view('treatments.index')
            ->with('treatments', $treatments);
    }

    /**
     * Show the form for creating a new Treatment.
     *
     * @return Response
     */
    public function create()
    {
        return view('treatments.create');
    }

    /**
     * Store a newly created Treatment in storage.
     *
     * @param CreateTreatmentRequest $request
     *
     * @return Response
     */
    public function store(CreateTreatmentRequest $request)
    {
        $input = $request->all();

        Validator::make($input, [
            'short_code' => [
                'required',
                Rule::unique('treatments')->where(function ($query) {
                    $query->where('branch_id', session('branch_id'));
                }),
            ],
            'description' => [
                'required',
                Rule::unique('treatments')->where(function ($query) {
                    $query->where('branch_id', session('branch_id'));
                }),
            ],
        ])->validate();

        $treatment = $this->treatmentRepository->create($input);

        Flash::success('Treatment saved successfully.');

        return redirect(route('treatments.index'));
    }

    /**
     * Display the specified Treatment.
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $treatment = $this->treatmentRepository->find($id);

        if (empty($treatment)) {
            Flash::error('Treatment not found');

            return redirect(route('treatments.index'));
        }

        return view('treatments.show')->with('treatment', $treatment);
    }

    /**
     * Show the form for editing the specified Treatment.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $treatment = $this->treatmentRepository->find($id);

        if (empty($treatment)) {
            Flash::error('Treatment not found');

            return redirect(route('treatments.index'));
        }

        return view('treatments.edit')->with('treatment', $treatment);
    }

    /**
     * Update the specified Treatment in storage.
     *
     * @param int $id
     * @param UpdateTreatmentRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateTreatmentRequest $request)
    {
        $treatment = $this->treatmentRepository->find($id);

        $input = $request->all();

        Validator::make($input, [
            'short_code' => [
                'required',
                Rule::unique('treatments')->ignore($treatment->id)->where(function ($query) {
                    $query->where('branch_id', session('branch_id'));
                }),
            ],
            'description' => [
                'required',
                Rule::unique('treatments')->ignore($treatment->id)->where(function ($query) {
                    $query->where('branch_id', session('branch_id'));
                }),
            ],
        ])->validate();

        if (empty($treatment)) {
            Flash::error('Treatment not found');

            return redirect(route('treatments.index'));
        }

        $treatment = $this->treatmentRepository->update($request->all(), $id);

        Flash::success('Treatment updated successfully.');

        return redirect(route('treatments.index'));
    }

    /**
     * Remove the specified Treatment from storage.
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        $treatment = $this->treatmentRepository->find($id);

        if (empty($treatment)) {
            Flash::error('Treatment not found');

            return redirect(route('treatments.index'));
        }

        $this->treatmentRepository->delete($id);

        Flash::success('Treatment deleted successfully.');

        return redirect(route('treatments.index'));
    }
}
