<?php

namespace App\Repositories;

use App\Models\Specialization;
use App\Repositories\BaseRepository;

/**
 * Class SpecializationRepository
 * @package App\Repositories
 * @version September 14, 2020, 6:01 pm UTC
*/

class SpecializationRepository extends BaseRepository
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
        return Specialization::class;
    }
}
