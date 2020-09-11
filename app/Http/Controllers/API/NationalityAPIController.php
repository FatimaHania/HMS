<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateNationalityAPIRequest;
use App\Http\Requests\API\UpdateNationalityAPIRequest;
use App\Models\Nationality;
use App\Repositories\NationalityRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use Response;

/**
 * Class NationalityController
 * @package App\Http\Controllers\API
 */

class NationalityAPIController extends AppBaseController
{
    /** @var  NationalityRepository */
    private $nationalityRepository;

    public function __construct(NationalityRepository $nationalityRepo)
    {
        $this->nationalityRepository = $nationalityRepo;
    }

    /**
     * Display a listing of the Nationality.
     * GET|HEAD /nationalities
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $nationalities = $this->nationalityRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

        return $this->sendResponse($nationalities->toArray(), 'Nationalities retrieved successfully');
    }

    /**
     * Store a newly created Nationality in storage.
     * POST /nationalities
     *
     * @param CreateNationalityAPIRequest $request
     *
     * @return Response
     */
    public function store(CreateNationalityAPIRequest $request)
    {
        $input = $request->all();

        $nationality = $this->nationalityRepository->create($input);

        return $this->sendResponse($nationality->toArray(), 'Nationality saved successfully');
    }

    /**
     * Display the specified Nationality.
     * GET|HEAD /nationalities/{id}
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var Nationality $nationality */
        $nationality = $this->nationalityRepository->find($id);

        if (empty($nationality)) {
            return $this->sendError('Nationality not found');
        }

        return $this->sendResponse($nationality->toArray(), 'Nationality retrieved successfully');
    }

    /**
     * Update the specified Nationality in storage.
     * PUT/PATCH /nationalities/{id}
     *
     * @param int $id
     * @param UpdateNationalityAPIRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateNationalityAPIRequest $request)
    {
        $input = $request->all();

        /** @var Nationality $nationality */
        $nationality = $this->nationalityRepository->find($id);

        if (empty($nationality)) {
            return $this->sendError('Nationality not found');
        }

        $nationality = $this->nationalityRepository->update($input, $id);

        return $this->sendResponse($nationality->toArray(), 'Nationality updated successfully');
    }

    /**
     * Remove the specified Nationality from storage.
     * DELETE /nationalities/{id}
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var Nationality $nationality */
        $nationality = $this->nationalityRepository->find($id);

        if (empty($nationality)) {
            return $this->sendError('Nationality not found');
        }

        $nationality->delete();

        return $this->sendSuccess('Nationality deleted successfully');
    }
}
