<?php

namespace App\Repositories;

use App\Models\Treatment;
use App\Repositories\BaseRepository;

/**
 * Class TreatmentRepository
 * @package App\Repositories
 * @version September 14, 2020, 6:25 pm UTC
*/

class TreatmentRepository extends BaseRepository
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
        return Treatment::class;
    }
}
