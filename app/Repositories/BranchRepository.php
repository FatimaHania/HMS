<?php

namespace App\Repositories;

use App\Models\Branch;
use App\Models\Country;
use App\Models\Currency;
use App\Repositories\BaseRepository;

/**
 * Class BranchRepository
 * @package App\Repositories
 * @version August 30, 2020, 5:52 pm UTC
*/

class BranchRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'hospital_id',
        'name',
        'short_code',
        'telephone_1',
        'telephone_2',
        'telephone_3',
        'address'
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
        return Branch::class;
    }

    public function getCountries()
    {

        return Country::orderBy('description', 'ASC')->pluck('description' , 'id');

    }

    public function getCurrencies()
    {

        return Currency::orderBy('description', 'ASC')->pluck('description' , 'id');

    }


}
