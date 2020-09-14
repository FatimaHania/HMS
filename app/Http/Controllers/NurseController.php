<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateNurseRequest;
use App\Http\Requests\UpdateNurseRequest;
use App\Repositories\NurseRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Response;
use Illuminate\Validation\Rule;
use Validator;

use App\Models\Nurse;
use App\Models\Title;
use App\Models\Gender;
use App\Models\Country;
use App\Models\Nationality;
use App\Models\DocumentCode;

class NurseController extends AppBaseController
{
    /** @var  NurseRepository */
    private $nurseRepository;

    public function __construct(NurseRepository $nurseRepo)
    {
        $this->nurseRepository = $nurseRepo;
    }

    /**
     * Display a listing of the Nurse.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function index(Request $request)
    {
        $nurses = $this->nurseRepository->getAll();

        return view('nurses.index')
            ->with('nurses', $nurses);
    }

    /**
     * Show the form for creating a new Nurse.
     *
     * @return Response
     */
    public function create()
    {
        
        $titles = Title::pluck('short_code' , 'id');
        $genders = Gender::pluck('description' , 'id');
        $countries = Country::pluck('description' , 'id');
        $nationalities = Nationality::pluck('description' , 'id');
        $documentCode = DocumentCode::where('documentcode_id' , 3)->first();
        $lastNurseRecord = Nurse::orderBy('nurse_number', 'DESC')->first();

        return view('nurses.create')
        ->with('titles', $titles)
        ->with('genders', $genders)
        ->with('countries', $countries)
        ->with('nationalities', $nationalities)
        ->with('documentCode', $documentCode)
        ->with('lastNurseRecord', $lastNurseRecord);
    }

    /**
     * Store a newly created Nurse in storage.
     *
     * @param CreateNurseRequest $request
     *
     * @return Response
     */
    public function store(CreateNurseRequest $request)
    {
        $input = $request->all();

        Validator::make($input, [
            'nurse_code' => [
                'required',
                Rule::unique('nurses')->where(function ($query) {
                    $query->where('branch_id', session('branch_id'));
                }),
            ],
        ])->validate();

        if(request('nurse_image_upload')) {

            $input['nurse_image'] = request('nurse_image_upload')->storeAs('images/nurses' , 'NUR-'.session('hospital_id').session('branch_id').'-'.$input['nurse_code'].'.'.($request->nurse_image_upload->extension()));

        }

        $nurse = $this->nurseRepository->create($input);

        Flash::success('Nurse saved successfully.');

        return redirect(route('nurses.index'));
    }

    /**
     * Display the specified Nurse.
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $nurse = $this->nurseRepository->find($id);

        if (empty($nurse)) {
            Flash::error('Nurse not found');

            return redirect(route('nurses.index'));
        }

        return view('nurses.show')->with('nurse', $nurse);
    }

    /**
     * Show the form for editing the specified Nurse.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit($id)
    {

        $nurse = $this->nurseRepository->find($id);

        $titles = Title::pluck('short_code' , 'id');
        $genders = Gender::pluck('short_code' , 'id');
        $countries = Country::pluck('short_code' , 'id');
        $nationalities = Nationality::pluck('short_code' , 'id');
        $documentCode = DocumentCode::where('documentcode_id' , 3)->first();
        $lastNurseRecord = Nurse::orderBy('nurse_number', 'DESC')->first();
        
        if (empty($nurse)) {
            Flash::error('Nurse not found');

            return redirect(route('nurses.index'));
        }

        return view('nurses.edit')
        ->with('nurse', $nurse)
        ->with('titles', $titles)
        ->with('genders', $genders)
        ->with('countries', $countries)
        ->with('nationalities', $nationalities)
        ->with('documentCode', $documentCode)
        ->with('lastNurseRecord', $lastNurseRecord);
    }

    /**
     * Update the specified Nurse in storage.
     *
     * @param int $id
     * @param UpdateNurseRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateNurseRequest $request)
    {
        $nurse = $this->nurseRepository->find($id);

        $input = $request->all();

        Validator::make($input, [
            'nurse_code' => [
                'required',
                Rule::unique('nurses')->ignore($nurse->id)->where(function ($query) {
                    $query->where('branch_id', session('branch_id'));
                }),
            ],
        ])->validate();

        if (empty($nurse)) {
            Flash::error('Nurse not found');

            return redirect(route('nurses.index'));
        }

        $input = $request->all();

        if(request('nurse_image_upload')) {

            $input['nurse_image'] = request('nurse_image_upload')->storeAs('images/nurses' , 'NUR-'.session('hospital_id').session('branch_id').'-'.$input['nurse_code'].'.'.($request->nurse_image_upload->extension()));

        }

        $nurse = $this->nurseRepository->update($input, $id);

        Flash::success('Nurse updated successfully.');

        return redirect(route('nurses.index'));
    }

    /**
     * Remove the specified Nurse from storage.
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        $nurse = $this->nurseRepository->find($id);

        if (empty($nurse)) {
            Flash::error('Nurse not found');

            return redirect(route('nurses.index'));
        }

        $this->nurseRepository->delete($id);

        Flash::success('Nurse deleted successfully.');

        return redirect(route('nurses.index'));
    }
}
