<?php

namespace App\Repositories;

use App\Models\Laboratory;
use App\Models\DocumentCode;
use App\Repositories\BaseRepository;

/**
 * Class LaboratoryRepository
 * @package App\Repositories
 * @version January 16, 2021, 5:46 pm UTC
*/

class LaboratoryRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'lab_number',
        'lab_code',
        'name',
        'short_code',
        'address',
        'telephone_1',
        'telephone_2',
        'email',
        'is_active',
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
        return Laboratory::class;
    }

    /**
     * Get document code details of laboratory
     **/
    public function documentCode()
    {

        return DocumentCode::where('documentcode_id' , 6)->first();

    }


    /**
     * Get last laboratory record
     **/
    public function lastLabRecord()
    {

        return Laboratory::orderBy('lab_number', 'DESC')->first();

    }



}
