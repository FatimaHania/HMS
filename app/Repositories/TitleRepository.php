<?php

namespace App\Repositories;

use App\Models\Title;
use App\Repositories\BaseRepository;

/**
 * Class TitleRepository
 * @package App\Repositories
 * @version August 22, 2020, 4:45 pm UTC
*/

class TitleRepository extends BaseRepository
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
        return Title::class;
    }
}
