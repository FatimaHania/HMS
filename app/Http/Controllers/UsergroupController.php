<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateUsergroupRequest;
use App\Http\Requests\UpdateUsergroupRequest;
use App\Repositories\UsergroupRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Response;

class UsergroupController extends AppBaseController
{
    /** @var  UsergroupRepository */
    private $usergroupRepository;

    public function __construct(UsergroupRepository $usergroupRepo)
    {
        $this->usergroupRepository = $usergroupRepo;
    }

    /**
     * Display a listing of the Usergroup.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function index(Request $request)
    {
        $usergroups = $this->usergroupRepository->all();

        return view('usergroups.index')
            ->with('usergroups', $usergroups);
    }

    /**
     * Show the form for creating a new Usergroup.
     *
     * @return Response
     */
    public function create()
    {
        return view('usergroups.create');
    }

    /**
     * Store a newly created Usergroup in storage.
     *
     * @param CreateUsergroupRequest $request
     *
     * @return Response
     */
    public function store(CreateUsergroupRequest $request)
    {
        $input = $request->all();

        $usergroup = $this->usergroupRepository->create($input);

        Flash::success('Usergroup saved successfully.');

        return redirect(route('usergroups.index'));
    }

    /**
     * Display the specified Usergroup.
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $usergroup = $this->usergroupRepository->find($id);

        if (empty($usergroup)) {
            Flash::error('Usergroup not found');

            return redirect(route('usergroups.index'));
        }

        return view('usergroups.show')->with('usergroup', $usergroup);
    }

    /**
     * Show the form for editing the specified Usergroup.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $usergroup = $this->usergroupRepository->find($id);

        if (empty($usergroup)) {
            Flash::error('Usergroup not found');

            return redirect(route('usergroups.index'));
        }

        return view('usergroups.edit')->with('usergroup', $usergroup);
    }

    /**
     * Update the specified Usergroup in storage.
     *
     * @param int $id
     * @param UpdateUsergroupRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateUsergroupRequest $request)
    {
        $usergroup = $this->usergroupRepository->find($id);

        if (empty($usergroup)) {
            Flash::error('Usergroup not found');

            return redirect(route('usergroups.index'));
        }

        $usergroup = $this->usergroupRepository->update($request->all(), $id);

        Flash::success('Usergroup updated successfully.');

        return redirect(route('usergroups.index'));
    }

    

    /**
     * Display the specified Usergroup Modules.
     *
     * @return Response
     */
    public function getUsergroupModules()
    {

        $usergroup_id = $_POST['usergroup_id'];

        $usergroup_modules = $this->usergroupRepository->getUsergroupModules($usergroup_id);
        $modules = $this->usergroupRepository->getAllModules($usergroup_id);

        return view('usergroups.modules.modules_table')
            ->with('modules', $modules)
            ->with('usergroup_modules', $usergroup_modules);

    }


    /**
     * Store a newly created Usergroup Modules in storage.
     *
     *
     */
    public function storeUsergroupModules()
    {

        $usergroup_id = $_POST['usergroup_id'];
        $module_id_array = $_POST['module_id_array'];
        $selected_value_array = $_POST['selected_value_array'];

        return $this->usergroupRepository->storeUsergroupModules($usergroup_id , $module_id_array, $selected_value_array);
        
    }



    /**
     * Remove the specified Usergroup from storage.
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        $usergroup = $this->usergroupRepository->find($id);

        if (empty($usergroup)) {
            Flash::error('Usergroup not found');

            return redirect(route('usergroups.index'));
        }

        $this->usergroupRepository->delete($id);

        Flash::success('Usergroup deleted successfully.');

        return redirect(route('usergroups.index'));
    }
}
