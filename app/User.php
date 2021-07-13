<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'usertype_id', 'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    //Users hospitals
    public function getUserHospital(){

        $users = DB::table('user_hospital')
            ->join('hospitals', 'hospitals.id', '=', 'user_hospital.hospital_id')
            ->join('branches', 'branches.id', '=', 'user_hospital.branch_id')
            ->join('currencies', 'currencies.id', '=', 'branches.default_currency_id')
            ->join('countries', 'countries.id', '=', 'branches.country_id')
            ->select('hospitals.*' , 'branches.*' , 'countries.*' , 'user_hospital.*' , 'currencies.short_code as branch_currency_short_code' , 'currencies.decimal_places as branch_currency_decimal_places', 'user_hospital.hospital_id', 'user_hospital.branch_id' , 'hospitals.name AS hospital_name' , 'branches.name AS branch_name')
            ->where('user_hospital.user_id', Auth::id())
            ->get();

            return $users;

    }

    public function getPhysicianHospitals($user_id){

        $physician_hospitals = DB::table('user_hospital')
            ->join('hospitals', 'hospitals.id', '=', 'user_hospital.hospital_id')
            ->join('branches', 'branches.id', '=', 'user_hospital.branch_id')
            ->select('hospitals.*' , 'branches.*' , 'user_hospital.*' , 'user_hospital.hospital_id', 'user_hospital.branch_id' , 'hospitals.name AS hospital_name' , 'branches.name AS branch_name')
            ->where([['user_hospital.user_id', Auth::id()] , ['user_hospital.is_physician' , '1']])
            ->get();

        return $physician_hospitals;


    }


    public function getPatientHospitals($user_id){

        $patient_hospitals = DB::table('user_hospital')
        ->join('hospitals', 'hospitals.id', '=', 'user_hospital.hospital_id')
        ->join('branches', 'branches.id', '=', 'user_hospital.branch_id')
        ->select('hospitals.*' , 'branches.*' , 'user_hospital.*' , 'user_hospital.hospital_id', 'user_hospital.branch_id' , 'hospitals.name AS hospital_name' , 'branches.name AS branch_name')
        ->where([['user_hospital.user_id', Auth::id()] , ['user_hospital.is_physician' , '0'] , ['user_hospital.user_link_id' , '!=' , '0']])
        ->whereNotNull('user_link_id')
        ->get();

        return $patient_hospitals; 

    }


    //Users Usergroups
    public function getUserUsergroups($hospital_id, $branch_id){

        $user_usergroups = DB::table('user_usergroup')
            ->select('user_usergroup.usergroup_id')
            ->where([['user_usergroup.user_id', Auth::id()] , ['user_usergroup.hospital_id' , $hospital_id] , ['user_usergroup.branch_id' , $branch_id]])
            ->get();

            return $user_usergroups;

    }

    // User Model
    public function userImage()
    {
        if($this->user_image == "" || $this->user_image == null){
            return '/storage/images/users/default.png';
        } else {
            if (file_exists( public_path() . '/storage/' . $this->user_image)) {
                return '/storage/' . $this->user_image;
            } else {
                return '/storage/images/sys_public_user.png';
            }    
        }
    }


}
