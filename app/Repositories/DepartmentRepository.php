<?php

namespace App\Repositories;

use App\Models\Department;
use App\Models\Room;
use App\Repositories\BaseRepository;

/**
 * Class DepartmentRepository
 * @package App\Repositories
 * @version September 14, 2020, 6:11 pm UTC
*/

class DepartmentRepository extends BaseRepository
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
        return Department::class;
    }

    //UPDATE ROOM FILTER
    public function updateDepartmentRoomFilter($department_id){
        if($department_id == "0" || $department_id == "" || $department_id == null){
            $rooms = Room::all();
        } else {
            $rooms = Department::find($department_id)->rooms()->get();
        }

        $room_opt = "";
        foreach($rooms as $room) {
            $room_opt .= "<option value='".$room->id."'>".$room->description."</option>";
        }

        return $room_opt;
    }

}
