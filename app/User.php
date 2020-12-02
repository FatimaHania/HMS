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
        'name', 'email', 'password',
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

    public function getUserHospital(){

        $users = DB::table('user_hospital')
            ->join('hospitals', 'hospitals.id', '=', 'user_hospital.hospital_id')
            ->join('branches', 'branches.id', '=', 'user_hospital.branch_id')
            ->join('currencies', 'currencies.id', '=', 'branches.default_currency_id')
            ->select('hospitals.*' , 'branches.*' , 'currencies.short_code as branch_currency_short_code', 'user_hospital.hospital_id', 'user_hospital.branch_id' , 'hospitals.name AS hospital_name' , 'branches.name AS branch_name')
            ->where('user_hospital.user_id', Auth::id())
            ->get();

            return $users;

    }


    public function getUserUsergroups($hospital_id, $branch_id){

        $user_usergroups = DB::table('user_usergroup')
            ->select('user_usergroup.usergroup_id')
            ->where([['user_usergroup.user_id', Auth::id()] , ['user_usergroup.hospital_id' , $hospital_id] , ['user_usergroup.branch_id' , $branch_id]])
            ->get();

            return $user_usergroups;

    }

}
