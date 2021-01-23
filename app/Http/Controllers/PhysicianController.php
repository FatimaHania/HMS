<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreatePhysicianRequest;
use App\Http\Requests\UpdatePhysicianRequest;
use App\Repositories\PhysicianRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Response;
use Illuminate\Validation\Rule;
use Validator;

use App\Models\Physician;
use App\Models\Title;
use App\Models\Gender;
use App\Models\Country;
use App\Models\Nationality;
use App\Models\DocumentCode;
use App\Models\Department;
use App\Models\Specialization;

class PhysicianController extends AppBaseController
{
    /** @var  PhysicianRepository */
    private $physicianRepository;

    public function __construct(PhysicianRepository $physicianRepo)
    {
        $this->physicianRepository = $physicianRepo;
    }

    /**
     * Display a listing of the Physician.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function index(Request $request)
    {
        $physicians = $this->physicianRepository->getAll();
        $departments = Department::all();
        $specializations = Specialization::all();


        return view('physicians.index')
            ->with('physicians', $physicians)
            ->with('departments', $departments)
            ->with('specializations', $specializations);
    }

    /**
     * Show the form for creating a new Physician.
     *
     * @return Response
     */
    public function create()
    {

        $titles = Title::pluck('short_code' , 'id');
        $genders = Gender::pluck('description' , 'id');
        $countries = Country::pluck('description' , 'id');
        $nationalities = Nationality::pluck('description' , 'id');
        $documentCode = DocumentCode::where('documentcode_id' , 2)->first();
        $lastPhysicianRecord = Physician::orderBy('physician_number', 'DESC')->withTrashed()->first();

        return view('physicians.create')
        ->with('titles', $titles)
        ->with('genders', $genders)
        ->with('countries', $countries)
        ->with('nationalities', $nationalities)
        ->with('documentCode', $documentCode)
        ->with('lastPhysicianRecord', $lastPhysicianRecord);
    }

    /**
     * Store a newly created Physician in storage.
     *
     * @param CreatePhysicianRequest $request
     *
     * @return Response
     */
    public function store(CreatePhysicianRequest $request)
    {
        $input = $request->all();

        Validator::make($input, [
            'physician_code' => [
                'required',
                Rule::unique('physicians')->where(function ($query) {
                    $query->where('branch_id', session('branch_id'));
                }),
            ],
        ])->validate();


        if(request('physician_image_upload')) {

            $input['physician_image'] = request('physician_image_upload')->storeAs('images/physicians' , 'PHY-'.session('hospital_id').session('branch_id').'-'.$input['physician_code'].'.'.($request->physician_image_upload->extension()));

        }

        $physician = $this->physicianRepository->create($input);

        Flash::success('Physician saved successfully.');

        return redirect(route('physicians.index'));
    }

    /**
     * Display the specified Physician.
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $physician = $this->physicianRepository->find($id);

        if (empty($physician)) {
            Flash::error('Physician not found');

            return redirect(route('physicians.index'));
        }

        return view('physicians.show')->with('physician', $physician);
    }

    /**
     * Show the form for editing the specified Physician.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $physician = $this->physicianRepository->find($id);

        $titles = Title::pluck('short_code' , 'id');
        $genders = Gender::pluck('description' , 'id');
        $countries = Country::pluck('description' , 'id');
        $nationalities = Nationality::pluck('description' , 'id');
        $documentCode = DocumentCode::where('documentcode_id' , 2)->first();
        $lastPhysicianRecord = Physician::orderBy('physician_number', 'DESC')->withTrashed()->first();

        if (empty($physician)) {
            Flash::error('Physician not found');

            return redirect(route('physicians.index'));
        }

        return view('physicians.edit')
        ->with('physician', $physician)
        ->with('titles', $titles)
        ->with('genders', $genders)
        ->with('countries', $countries)
        ->with('nationalities', $nationalities)
        ->with('documentCode', $documentCode)
        ->with('lastPhysicianRecord', $lastPhysicianRecord);
    }

    /**
     * Update the specified Physician in storage.
     *
     * @param int $id
     * @param UpdatePhysicianRequest $request
     *
     * @return Response
     */
    public function update($id, UpdatePhysicianRequest $request)
    {
        $physician = $this->physicianRepository->find($id);

        $input = $request->all();

        Validator::make($input, [
            'physician_code' => [
                'required',
                Rule::unique('physicians')->ignore($physician->id)->where(function ($query) {
                    $query->where('branch_id', session('branch_id'));
                }),
            ],
        ])->validate();

        if (empty($physician)) {
            Flash::error('Physician not found');

            return redirect(route('physicians.index'));
        }

        $input = $request->all();

        if(request('physician_image_upload')) {

            $input['physician_image'] = request('physician_image_upload')->storeAs('images/physicians' , 'PHY-'.session('hospital_id').session('branch_id').'-'.$input['physician_code'].'.'.($request->physician_image_upload->extension()));

        }

        $physician = $this->physicianRepository->update($input, $id);

        Flash::success('Physician updated successfully.');

        if(session('is_physician') == '1'){
            return redirect(route('home'));
        } else {
            return redirect(route('physicians.index'));
        }
    }


    /**
     * Display the specified Physician Departments.
     *
     * @return Response
     */
    public function getPhysicianDepartments()
    {

        $physician_id = $_POST['physician_id'];

        $departments = $this->physicianRepository->getPhysicianDepartments($physician_id);

        return view('physicians.departments.departments_table')
            ->with('departments', $departments);

    }

    /**
     * Remove the specified Physician Department from storage.
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroyPhysicianDepartments()
    {

        $physician_id = $_POST['physician_id'];
        $department_id = $_POST['department_id'];

        return $this->physicianRepository->destroyPhysicianDepartments($physician_id , $department_id);

    }


    /**
     * Store a newly created Physician Department in storage.
     *
     *
     */
    public function storePhysicianDepartments()
    {

        $physician_id = $_POST['physician_id'];
        $department_id = $_POST['department_id'];

        return $this->physicianRepository->storePhysicianDepartments($physician_id , $department_id);
        
    }



    /**
     * Display the specified Physician Specialization.
     *
     * @return Response
     */
    public function getPhysicianSpecializations()
    {

        $physician_id = $_POST['physician_id'];

        $specializations = $this->physicianRepository->getPhysicianSpecializations($physician_id);

        return view('physicians.specializations.specializations_table')
            ->with('specializations', $specializations);

    }

    /**
     * Remove the specified Physician Specialization from storage.
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroyPhysicianSpecializations()
    {

        $physician_id = $_POST['physician_id'];
        $specialization_id = $_POST['specialization_id'];

        return $this->physicianRepository->destroyPhysicianSpecializations($physician_id , $specialization_id);

    }


    /**
     * Store a newly created Physician Specialization in storage.
     *
     *
     */
    public function storePhysicianSpecializations()
    {

        $physician_id = $_POST['physician_id'];
        $specialization_id = $_POST['specialization_id'];

        return $this->physicianRepository->storePhysicianSpecializations($physician_id , $specialization_id);
        
    }



    /**
     * Remove the specified Physician from storage.
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        $physician = $this->physicianRepository->find($id);

        if (empty($physician)) {
            Flash::error('Physician not found');

            return redirect(route('physicians.index'));
        }

        $this->physicianRepository->delete($id);

        Flash::success('Physician deleted successfully.');

        return redirect(route('physicians.index'));
    }
}
