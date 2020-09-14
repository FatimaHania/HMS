<?php

namespace App\Repositories;

use App\Models\Nurse;
use App\Repositories\BaseRepository;

/**
 * Class NurseRepository
 * @package App\Repositories
 * @version September 13, 2020, 4:05 pm UTC
*/

class NurseRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'nurse_number',
        'nurse_code',
        'nurse_name',
        'nurse_image',
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
        return Nurse::class;
    }

    public function getAll(){
        return Nurse::with(['country','gender','title'])->get();
    }

}
