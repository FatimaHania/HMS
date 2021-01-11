<?php

namespace App\Repositories;

use App\Models\User;
use App\Models\Usergroup;
use App\Models\Branch;
use App\Models\Patient;
use App\Models\Physician;
use App\Repositories\BaseRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

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
    public function usergroups(){ //get all usergroups
        return Usergroup::all();
    }

    public function getUserUsergroups($user_id){ //get user's usergroups
        $user = User::find($user_id);
        return $user->usergroups()->get();
    }


    public function destroyUserUsergroups($user_id , $usergroup_id){ //destroy user's usergroup
        $user = User::find($user_id);
        return $user->usergroups()->wherePivot('usergroup_id' , $usergroup_id)->detach();
    }


    public function storeUserUsergroups($user_id , $usergroup_id){ //Store user's usegroup
        $user = User::find($user_id);
        return $user->usergroups()->syncWithoutDetaching([$usergroup_id => [ 'hospital_id' => session('hospital_id') , 'branch_id' => session('branch_id')]]);
    }

    //Update user profile from public portal
    public function updateUserProfile($data, $id)
    {

        return user::where('id', $id)
                    ->update(['name' => $data['name'] , 'email' => $data['email'] , 'user_image' => $data['user_image']]);

    }

    //link user to hospital
    public function linkHospital($data, $id)
    {

        $user = User::find($id);

        $hospital = Branch::select('hospital_id','name')->where('id', $data['link_hospital'])->first();

        $hospital_name = "";
        if(!empty($hospital)){

            $hospital_name = $hospital->hospital->name.", ".$hospital->name;

            $user_link_id = null;
            $user_link_email = null;
            if($data['link_type'] == "0"){ //Patient

                $patient = Patient::withoutGlobalScope('App\Scopes\HospitalScope'::class)->where([['passport_no' , '=' , $data['passport_no']] , ['email' , '=' , $data['registered_email']] , ['branch_id' , '=' , $data['link_hospital']]])->first();
                if(!empty($patient)){
                    $user_link_id = $patient->id;
                    $user_link_email = $patient->email;
                }

            } else { //physician

                $physician = Physician::withoutGlobalScope('App\Scopes\HospitalScope'::class)->where([['passport_no' , '=' , $data['passport_no']] , ['email' , '=' , $data['registered_email']] , ['branch_id' , '=' , $data['link_hospital']]])->first();
                if(!empty($physician)){
                    $user_link_id = $physician->id;
                    $user_link_email = $physician->email;
                }

            }

            if($user_link_id == "0" || $user_link_id == null || $user_link_id == ""){
                $result = array(
                    'status' => 'Failed',
                    'hospital_name' => $hospital_name,
                    'user_name' => Auth::user()->name,
                    'linked_user_email' => '',
                    'verification_token' => ''
                );
            } else {
                if($user->branches()->where(['user_id' => $id , 'branch_id' => $data['link_hospital'] , 'user_link_id' => $user_link_id , 'is_physician' => $data['link_type']])->count() === 0){
                    
                    $random_string = Str::random(16);
                    $token = strtotime(date('Y-m-d H:i:s')).$random_string;
                    $user->branches()->attach([$data['link_hospital'] => ['hospital_id' => $hospital->hospital_id , 'user_link_id' => $user_link_id, 'link_verification_token' => $token , 'is_physician' => $data['link_type']]]);
                    
                    $result = array(
                        'status' => 'Success',
                        'hospital_name' => $hospital_name,
                        'user_name' => Auth::user()->name,
                        'linked_user_email' => $user_link_email,
                        'verification_token' => $token
                    );

                } else {

                    $result = array(
                        'status' => 'Exists',
                        'hospital_name' => $hospital_name,
                        'user_name' => Auth::user()->name,
                        'linked_user_email' => '',
                        'verification_token' => ''
                    );
                }
            }

            return $result;

        }



    }


    //verify hospital link
    public function verifyHospitalLink($verification_token)
    {

        $current_time = now();

        $verify = DB::update(
            'update user_hospital set link_verified_at = "'.$current_time.'" where link_verification_token = ?',
            [$verification_token]
        );

    }

}
