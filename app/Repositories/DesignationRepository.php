<?php

namespace App\Repositories;

use App\Models\Designation;
use App\Repositories\BaseRepository;

/**
 * Class DesignationRepository
 * @package App\Repositories
 * @version September 28, 2020, 5:06 pm UTC
*/

class DesignationRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'title',
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
        return Designation::class;
    }
}
