<?php

namespace App\Repositories;

use App\Models\Department;
use App\Models\DepartmentRoom;
use App\Repositories\BaseRepository;

/**
 * Class DepartmentRoomRepository
 * @package App\Repositories
 * @version October 3, 2020, 3:42 pm UTC
*/

class DepartmentRoomRepository extends BaseRepository
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
        return DepartmentRoom::class;
    }


    public function getDepartmentRooms($department_id){
        $department = Department::find($department_id);
        return $department->rooms()->get();
    }


    public function destroyDepartmentRooms($department_id , $room_id){
        $department = Department::find($department_id);
        return $department->rooms()->wherePivot('room_id' , $room_id)->detach();
    }


    public function storeDepartmentRooms($department_id , $room_id){
        $department = Department::find($department_id);
        return $department->rooms()->syncWithoutDetaching([$room_id => [ 'hospital_id' => session('hospital_id') , 'branch_id' => session('branch_id')]]);
    }

}
