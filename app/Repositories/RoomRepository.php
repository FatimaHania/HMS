<?php

namespace App\Repositories;

use App\Models\Room;
use App\Repositories\BaseRepository;

/**
 * Class RoomRepository
 * @package App\Repositories
 * @version October 2, 2020, 6:08 pm UTC
*/

class RoomRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'short_code',
        'description',
        'sort_order',
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
        return Room::class;
    }
}
