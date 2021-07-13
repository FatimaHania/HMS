<?php

namespace App\Repositories;

use App\Models\Pharmacy;
use App\Models\DocumentCode;
use App\Repositories\BaseRepository;

/**
 * Class PharmacyRepository
 * @package App\Repositories
 * @version January 16, 2021, 5:47 pm UTC
*/

class PharmacyRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'pharmacy_number',
        'pharmacy_code',
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
        return Pharmacy::class;
    }

    /**
     * Get document code details of pharmacy
     **/
    public function documentCode()
    {

        return DocumentCode::where('documentcode_id' , 5)->first();

    }


    /**
     * Get last pharmacy record
     **/
    public function lastPharmacyRecord()
    {

        return Pharmacy::orderBy('pharmacy_number', 'DESC')->first();

    }

}
