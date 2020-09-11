<?php

namespace App\Repositories;

use App\Models\Gender;
use App\Repositories\BaseRepository;

/**
 * Class GenderRepository
 * @package App\Repositories
 * @version August 22, 2020, 4:46 pm UTC
*/

class GenderRepository extends BaseRepository
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
        return Gender::class;
    }
}
