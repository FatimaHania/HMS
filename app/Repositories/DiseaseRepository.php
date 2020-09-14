<?php

namespace App\Repositories;

use App\Models\Disease;
use App\Repositories\BaseRepository;

/**
 * Class DiseaseRepository
 * @package App\Repositories
 * @version September 14, 2020, 6:17 pm UTC
*/

class DiseaseRepository extends BaseRepository
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
        return Disease::class;
    }
}
