<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

use Illuminate\Http\Request;

use App\User;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    protected function authenticated(Request $request, $user)
    {
        $this->setUserSession($user);
    }

    protected function setUserSession($user)
    {

        $user_hospitals = new User();

        $user_details_arr = array();
        foreach ($user_hospitals->getUserHospital() as $user_hospital) {

            $usergroups_arr = array();
            $user_usergroups = $user_hospitals->getUserUsergroups($user_hospital->hospital_id , $user_hospital->branch_id);
            foreach ($user_usergroups as $user_usergroup) {
                $usergroups_arr[] = $user_usergroup->usergroup_id;
            }

            $user_details = array(
                'hospitals' => $user_hospital,
                'usergroup_id' => $usergroups_arr
            );

            $user_details_arr[$user_hospital->branch_id] = $user_details;

        }

        session(
            [
                'hospital_id' => $user_hospitals->getUserHospital()[0]->hospital_id,
                'branch_id' => $user_hospitals->getUserHospital()[0]->branch_id,
                'user_details' => $user_details_arr
            ]
        );
    }


}
