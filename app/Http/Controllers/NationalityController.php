<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateNationalityRequest;
use App\Http\Requests\UpdateNationalityRequest;
use App\Repositories\NationalityRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Response;

class NationalityController extends AppBaseController
{
    /** @var  NationalityRepository */
    private $nationalityRepository;

    public function __construct(NationalityRepository $nationalityRepo)
    {
        $this->nationalityRepository = $nationalityRepo;
    }

    /**
     * Display a listing of the Nationality.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function index(Request $request)
    {
        $nationalities = $this->nationalityRepository->all();

        return view('nationalities.index')
            ->with('nationalities', $nationalities);
    }

    /**
     * Show the form for creating a new Nationality.
     *
     * @return Response
     */
    public function create()
    {
        return view('nationalities.create');
    }

    /**
     * Store a newly created Nationality in storage.
     *
     * @param CreateNationalityRequest $request
     *
     * @return Response
     */
    public function store(CreateNationalityRequest $request)
    {
        $input = $request->all();

        $nationality = $this->nationalityRepository->create($input);

        Flash::success('Nationality saved successfully.');

        return redirect(route('nationalities.index'));
    }

    /**
     * Display the specified Nationality.
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $nationality = $this->nationalityRepository->find($id);

        if (empty($nationality)) {
            Flash::error('Nationality not found');

            return redirect(route('nationalities.index'));
        }

        return view('nationalities.show')->with('nationality', $nationality);
    }

    /**
     * Show the form for editing the specified Nationality.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $nationality = $this->nationalityRepository->find($id);

        if (empty($nationality)) {
            Flash::error('Nationality not found');

            return redirect(route('nationalities.index'));
        }

        return view('nationalities.edit')->with('nationality', $nationality);
    }

    /**
     * Update the specified Nationality in storage.
     *
     * @param int $id
     * @param UpdateNationalityRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateNationalityRequest $request)
    {
        $nationality = $this->nationalityRepository->find($id);

        if (empty($nationality)) {
            Flash::error('Nationality not found');

            return redirect(route('nationalities.index'));
        }

        $nationality = $this->nationalityRepository->update($request->all(), $id);

        Flash::success('Nationality updated successfully.');

        return redirect(route('nationalities.index'));
    }

    /**
     * Remove the specified Nationality from storage.
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        $nationality = $this->nationalityRepository->find($id);

        if (empty($nationality)) {
            Flash::error('Nationality not found');

            return redirect(route('nationalities.index'));
        }

        $this->nationalityRepository->delete($id);

        Flash::success('Nationality deleted successfully.');

        return redirect(route('nationalities.index'));
    }
}
