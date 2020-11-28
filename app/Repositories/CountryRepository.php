<?php

namespace App\Repositories;

use App\Models\Country;
use App\Repositories\BaseRepository;

/**
 * Class CountryRepository
 * @package App\Repositories
 * @version August 22, 2020, 4:47 pm UTC
*/

class CountryRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'short_code',
        'description',
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
        return Country::class;
    }

    public function getTelephoneCode($country_id)
    {

        $country = Country::where('id' , $country_id)->first();

        return $country->telephone_code;

    }

    public function getCountryCurrency($country_id)
    {

        $country = Country::where('id' , $country_id)->first();

        return $country->currency_id;

    }


    public function getCountryNationality($country_id)
    {

        $country = Country::where('id' , $country_id)->first();

        return $country->nationality_id;

    }


}
