<?php

namespace App\Repositories;

use App\Models\Physician;
use App\Repositories\BaseRepository;

/**
 * Class PhysicianRepository
 * @package App\Repositories
 * @version September 6, 2020, 4:10 pm UTC
*/

class PhysicianRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'physician_number',
        'physician_code',
        'physician_name',
        'physician_image',
        'title_id',
        'gender_id',
        'dob',
        'country_id',
        'nationality_id',
        'passport_no',
        'mobile',
        'telephone',
        'address',
        'email',
        'hospital_id',
        'branch_id'
    ];

    /**
     * Return searchable fields
     *
     * @return array
     */
    public function getFieldsSearchable()
    {
        return $this->fieldSearchable;
    }

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Physician::class;
    }

    public function getAll(){
        return Physician::with(['country','gender','title'])->get();
    }


    //PHYSICIAN DEPARTMENTS
    public function getPhysicianDepartments($physician_id){
        $physician = Physician::find($physician_id);
        return $physician->departments()->get();
    }


    public function destroyPhysicianDepartments($physician_id , $department_id){
        $physician = Physician::find($physician_id);
        return $physician->departments()->wherePivot('department_id' , $department_id)->detach();
    }


    public function storePhysicianDepartments($physician_id , $department_id){
        $physician = Physician::find($physician_id);
        return $physician->departments()->syncWithoutDetaching([$department_id => [ 'hospital_id' => session('hospital_id') , 'branch_id' => session('branch_id')]]);
    }


    //PHYSICIAN SPECIALIZATIONS
    public function getPhysicianSpecializations($physician_id){
        $physician = Physician::find($physician_id);
        return $physician->specializations()->get();
    }


    public function destroyPhysicianSpecializations($physician_id , $specialization_id){
        $physician = Physician::find($physician_id);
        return $physician->specializations()->wherePivot('specialization_id' , $specialization_id)->detach();
    }


    public function storePhysicianSpecializations($physician_id , $specialization_id){
        $physician = Physician::find($physician_id);
        return $physician->specializations()->syncWithoutDetaching([$specialization_id => [ 'hospital_id' => session('hospital_id') , 'branch_id' => session('branch_id')]]);
    }
    

}
