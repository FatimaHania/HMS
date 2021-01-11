<?php

namespace App\Repositories;

use App\Models\User;
use App\Repositories\BaseRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

/**
 * Class PublicUserRepository
 * @package App\Repositories
 * @version October 2, 2020, 6:08 pm UTC
*/

class PublicUserRepository extends BaseRepository
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

    /**
     * get data for users filter
     **/
    public function updateUsersFilter($user_type)
    {

        if($user_type == '0'){//patients

            $linked_patients = DB::select('select patients.id as patient_id,patient_code,patient_name from user_hospital inner join patients on patients.id = user_hospital.user_link_id where user_hospital.branch_id="'.session('branch_id').'" and is_physician = "0" and user_link_id is not null');

            foreach($linked_patients as $linked_patient){
                echo "<option value='".$linked_patient->patient_id."'>".$linked_patient->patient_code." | ".$linked_patient->patient_name."</option>";
            }

        } else if($user_type == '1'){//physicians

            $linked_physicians = DB::select('select physicians.id as physician_id,physician_code,physician_name from user_hospital inner join physicians on physicians.id = user_hospital.user_link_id where user_hospital.branch_id="'.session('branch_id').'" and is_physician = "1" and user_link_id is not null');

            foreach($linked_physicians as $linked_physician){
                echo "<option value='".$linked_physician->physician_id."'>".$linked_physician->physician_code." | ".$linked_physician->physician_name."</option>";
            }

        }

    }

    /**
     * get linked users
     **/
    public function getLinkedUsers($user_type, $user)
    {

        if($user == "" || $user == null || $user == "0"){
            $linked_user_where_clause = ' and user_link_id is not null';
        } else {
            $linked_user_where_clause = ' and user_link_id="'.$user.'"';
        }

        if($user_type == '0'){//patients

            $linked_users = DB::select('select user_hospital.id as user_hospital_id, patients.id as linked_user_id,patient_code as linked_user_code,patient_name as linked_user_name, is_approved_by_hospital from user_hospital inner join patients on patients.id = user_hospital.user_link_id where user_hospital.branch_id="'.session('branch_id').'" and is_physician = "0" '. $linked_user_where_clause);

        } else if($user_type == '1'){//physicians

            $linked_users = DB::select('select user_hospital.id as user_hospital_id, physicians.id as linked_user_id,physician_code as linked_user_code,physician_name as linked_user_name, is_approved_by_hospital from user_hospital inner join physicians on physicians.id = user_hospital.user_link_id where user_hospital.branch_id="'.session('branch_id').'" and is_physician = "1" '.$linked_user_where_clause);

        }

        return $linked_users;

    }

    /**
     * Update is approved
     **/
    public function updateLinkApprovalStatus($user_hospital_id, $value)
    {

        $update_approval_status = DB::update(
            'update user_hospital set is_approved_by_hospital = ' . $value . ' where id = ?',
            [$user_hospital_id]
        );

        return $update_approval_status;

    }



}
