<?php

namespace App\Repositories;

use App\Models\Hospital;
use App\Repositories\BaseRepository;

/**
 * Class HospitalRepository
 * @package App\Repositories
 * @version August 30, 2020, 5:38 pm UTC
*/

class HospitalRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'name',
        'short_code',
        'logo'
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
        return Hospital::class;
    }


    public function getHospital()
    {

        return Hospital::where( 'id' , session('hospital_id') )->get();

    }
}
