<?php

namespace App\Repositories;

use App\Models\Bloodgroup;
use App\Repositories\BaseRepository;

/**
 * Class BloodgroupRepository
 * @package App\Repositories
 * @version August 22, 2020, 4:48 pm UTC
*/

class BloodgroupRepository extends BaseRepository
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
        return Bloodgroup::class;
    }
}
