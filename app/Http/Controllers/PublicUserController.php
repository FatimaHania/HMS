<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\PublicUserRepository;

class PublicUserController extends Controller
{
    

    /** @var  PublicUserRepository */
    private $publicUserRepository;

    public function __construct(PublicUserRepository $publicUserRepo)
    {
        $this->publicUserRepository = $publicUserRepo;
    }

    /**
     * Display a listing of the public users.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function index(Request $request)
    {

        $user_type = '0'; //load patient users by default
        $user = '';

        $linked_users = $this->publicUserRepository->getLinkedUsers($user_type, $user);

        return view('public_users.index')
        ->with('linked_users' , $linked_users);
    }


    /**
     * Update users filter.
     *
     */
    public function updateUsersFilter()
    {

        $user_type = $_POST['user_type'];

        return $this->publicUserRepository->updateUsersFilter($user_type);

    }

    /**
     * Get linked users
     *
     */
    public function getLinkedUsers()
    {

        $user_type = $_POST['user_type'];
        $user = $_POST['user'];

        $linked_users = $this->publicUserRepository->getLinkedUsers($user_type, $user);

        return view('public_users.table')
            ->with('linked_users' , $linked_users);

    }

    /**
     * Update is approved by hospital
     *
     */
    public function updateLinkApprovalStatus()
    {

        $user_hospital_id = $_POST['user_hospital_id'];
        $value = $_POST['value'];

        $update_approval_status = $this->publicUserRepository->updateLinkApprovalStatus($user_hospital_id, $value);

        return $update_approval_status;

    }


}
