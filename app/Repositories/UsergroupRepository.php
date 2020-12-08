<?php

namespace App\Repositories;

use App\Models\Usergroup;
use App\Models\Hospital;
use App\Repositories\BaseRepository;

/**
 * Class UsergroupRepository
 * @package App\Repositories
 * @version December 3, 2020, 6:17 pm UTC
*/

class UsergroupRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
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
        return Usergroup::class;
    }



    //Usergroup Modules

    public function getAllModules(){

        $hospital = Hospital::find(session('hospital_id'));
        return $hospital->modules()->orderBy('sort_order','ASC')->get();

    }

    public function getUsergroupModules($usergroup_id){
        $usergroup = Usergroup::find($usergroup_id);
        return $usergroup->modules()->orderBy('sort_order','ASC')->get();
    }



    public function storeUsergroupModules($usergroup_id , $module_id, $selected_value){
        $usergroup = Usergroup::find($usergroup_id);
        foreach($module_id as $mod_id){
            echo $mod_id."-----";
        }
        //return $usergroup->modules()->syncWithoutDetaching([$usergroup_id => [ 'hospital_id' => session('hospital_id') , 'branch_id' => session('branch_id')]]);
    }

}
