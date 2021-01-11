<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Repositories\UserRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Response;
use Illuminate\Validation\Rule;
use Validator;

use App\Mail\HospitalLinkVerification;
use Illuminate\Support\Facades\Mail;

class UserController extends AppBaseController
{
    /** @var  UserRepository */
    private $userRepository;

    public function __construct(UserRepository $userRepo)
    {
        $this->middleware('auth', ['except' => ['verifyHospitalLink']]);
        $this->userRepository = $userRepo;
    }

    /**
     * Display a listing of the User.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function index(Request $request)
    {
        $users = $this->userRepository->all();
        $usergroups = $this->userRepository->usergroups();

        return view('users.index')
            ->with('usergroups', $usergroups)
            ->with('users', $users);
    }

    /**
     * Show the form for creating a new User.
     *
     * @return Response
     */
    public function create()
    {
        return view('users.create');
    }

    /**
     * Store a newly created User in storage.
     *
     * @param CreateUserRequest $request
     *
     * @return Response
     */
    public function store(CreateUserRequest $request)
    {
        $input = $request->all();

        //$user = $this->userRepository->create($input);
        
        $user = app('App\Http\Controllers\Auth\RegisterController')->create($input);

        $this->userRepository->createUserHospitalLink($user);

        Flash::success('User saved successfully.');

        return redirect(route('users.index'));
    }

    /**
     * Display the specified User.
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $user = $this->userRepository->find($id);

        if (empty($user)) {
            Flash::error('User not found');

            return redirect(route('users.index'));
        }

        return view('users.show')->with('user', $user);
    }

    /**
     * Show the form for editing the specified User.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $user = $this->userRepository->find($id);

        if (empty($user)) {
            Flash::error('User not found');

            return redirect(route('users.index'));
        }

        return view('users.edit')->with('user', $user);
    }

    /**
     * Update the specified User in storage.
     *
     * @param int $id
     * @param UpdateUserRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateUserRequest $request)
    {
        
        $user = $this->userRepository->find($id);

        if (empty($user)) {
            Flash::error('User not found');

            return redirect(route('users.index'));
        }

        $user = $this->userRepository->update($request->all(), $id);

        Flash::success('User updated successfully.');

        return redirect(route('users.index'));

    }

    /**
     * Update the specified User in storage from the public user portal.
     *
     * @param  Request  $request
     * @param  int  $id
     * @return Response
     */
    public function updateUserProfile($id, Request $request)
    {


        $user = $this->userRepository->find($id);

        $input = $request->all();

        Validator::make($input, [
            'email' => [
                'required',
            ],
        ])->validate();

        if (empty($user)) {
            toastr()->error('User not found');

            return redirect(route('home'));
        }

        if(request('user_image_upload')) {

            $input['user_image'] = request('user_image_upload')->storeAs('images/users' , 'USR'.'-'.md5($id).'.'.($request->user_image_upload->extension()));

        }

        $user = $this->userRepository->updateUserProfile($input, $id);

        toastr()->success('Profile updated successfully');

        return redirect(route('home'));

    }


    /**
     * Link User to the Hospital.
     *
     * @param  Request  $request
     * @param  int  $id
     * @return Response
     */
    public function linkHospital($id, Request $request)
    {


        $user = $this->userRepository->find($id);

        $input = $request->all();

        if (empty($user)) {
            toastr()->error('User not found');

            return redirect(route('home'));
        }

        $linkHospital = $this->userRepository->linkHospital($input, $id);

        if($linkHospital['status'] == 'Success'){
            toastr()->success('Hospital linked successfully');

            //send verification email
            $emailContent = [
                'recipient' => $linkHospital['user_name'],
                'hospital_name' => $linkHospital['hospital_name'],
                'verification_link' => url('/users/verify/'.(($linkHospital['verification_token'])))
            ];

            Mail::to($linkHospital['linked_user_email'])->send(new HospitalLinkVerification($emailContent));

        } else if ($linkHospital['status'] == 'Exists'){
            toastr()->warning('The selected hospital has already been linked');
        } else {
            toastr()->error('Failed to link the hospital. Please check the registered identity number and the email');
        }

        return redirect(route('home'));

    }


    /**
     * Verify Hospital link.
     *
     * @param  string  $id
     * @return Response
     */
    public function verifyHospitalLink($id)
    {

        $verification_token = $id;
        $verify = $this->userRepository->verifyHospitalLink($verification_token);

        if($verify == '1'){
            toastr()->success('Your hospital link has been successfully verified.');
        } else {
            toastr()->error('Oops! Failed to verify hospital link.');
        }

        return redirect(route('login'));

    }
    

    /**
     * Display the specified User Usergroups.
     *
     * @return Response
     */
    public function getUserUsergroups()
    {

        $user_id = $_POST['user_id'];

        $usergroups = $this->userRepository->getUserUsergroups($user_id);

        return view('users.usergroups.usergroups_table')
            ->with('usergroups', $usergroups);

    }

    /**
     * Remove the specified User Usergroups from storage.
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroyUserUsergroups()
    {

        $user_id = $_POST['user_id'];
        $usergroup_id = $_POST['usergroup_id'];

        return $this->userRepository->destroyUserUsergroups($user_id , $usergroup_id);

    }


    /**
     * Store a newly created User Usergroup in storage.
     *
     *
     */
    public function storeUserUsergroups()
    {

        $user_id = $_POST['user_id'];
        $usergroup_id = $_POST['usergroup_id'];

        return $this->userRepository->storeUserUsergroups($user_id , $usergroup_id);
        
    }


    /**
     * Remove the specified User from storage.
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        $user = $this->userRepository->find($id);

        if (empty($user)) {
            Flash::error('User not found');

            return redirect(route('users.index'));
        }

        $this->userRepository->delete($id);

        Flash::success('User deleted successfully.');

        return redirect(route('users.index'));
    }
}
