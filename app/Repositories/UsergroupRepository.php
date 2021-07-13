<?php

namespace App\Repositories;

use App\Models\Usergroup;
use App\Models\Hospital;
use App\Models\Branch;
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

        $hospital = Branch::find(session('branch_id'));
        return $hospital->modules()->where('isActive','1')->orderBy('sort_order','ASC')->get();

    }

    public function getUsergroupModules($usergroup_id){
        $usergroup = Usergroup::find($usergroup_id);
        return $usergroup->modules()->where('isActive','1')->orderBy('sort_order','ASC')->get();
    }



    public function storeUsergroupModules($usergroup_id , $module_id_array, $selected_value_array){
        $usergroup = Usergroup::find($usergroup_id);

        $i = 0;
        $sync_arr = array();
        foreach($module_id_array as $module_id){

            $selected_value = $selected_value_array[$i];

            if($selected_value == '1'){
                $sync_arr[$module_id] = ['hospital_id' => session('hospital_id') , 'branch_id' => session('branch_id')];
            }

            $usergroup->modules()->sync($sync_arr);
            
            $i++;
        }
    }

}
