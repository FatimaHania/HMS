<?php

namespace App\Repositories;

use App\Models\User;
use App\Models\Usergroup;
use App\Repositories\BaseRepository;

/**
 * Class UserRepository
 * @package App\Repositories
 * @version December 3, 2020, 5:35 pm UTC
*/

class UserRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'name',
        'email',
        'email_verified_at',
        'password',
        'remember_token',
        'hospital_id',
        'branch_id',
        'usertype_id'
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
        return User::class;
    }


    public function createUserHospitalLink($user)
    {

        $user_record = User::find($user->id);
        $user_record->hospitals()->attach(session('hospital_id') , [ 'branch_id' => session('branch_id')]);

    }

    //USERGROUPS
    public function usergroups(){
        return Usergroup::all();
    }

    public function getUserUsergroups($user_id){
        $user = User::find($user_id);
        return $user->usergroups()->get();
    }


    public function destroyUserUsergroups($user_id , $usergroup_id){
        $user = User::find($user_id);
        return $user->usergroups()->wherePivot('usergroup_id' , $usergroup_id)->detach();
    }


    public function storeUserUsergroups($user_id , $usergroup_id){
        $user = User::find($user_id);
        return $user->usergroups()->syncWithoutDetaching([$usergroup_id => [ 'hospital_id' => session('hospital_id') , 'branch_id' => session('branch_id')]]);
    }

}
