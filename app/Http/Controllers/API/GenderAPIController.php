<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateGenderAPIRequest;
use App\Http\Requests\API\UpdateGenderAPIRequest;
use App\Models\Gender;
use App\Repositories\GenderRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use Response;

/**
 * Class GenderController
 * @package App\Http\Controllers\API
 */

class GenderAPIController extends AppBaseController
{
    /** @var  GenderRepository */
    private $genderRepository;

    public function __construct(GenderRepository $genderRepo)
    {
        $this->genderRepository = $genderRepo;
    }

    /**
     * Display a listing of the Gender.
     * GET|HEAD /genders
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $genders = $this->genderRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

        return $this->sendResponse($genders->toArray(), 'Genders retrieved successfully');
    }

    /**
     * Store a newly created Gender in storage.
     * POST /genders
     *
     * @param CreateGenderAPIRequest $request
     *
     * @return Response
     */
    public function store(CreateGenderAPIRequest $request)
    {
        $input = $request->all();

        $gender = $this->genderRepository->create($input);

        return $this->sendResponse($gender->toArray(), 'Gender saved successfully');
    }

    /**
     * Display the specified Gender.
     * GET|HEAD /genders/{id}
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var Gender $gender */
        $gender = $this->genderRepository->find($id);

        if (empty($gender)) {
            return $this->sendError('Gender not found');
        }

        return $this->sendResponse($gender->toArray(), 'Gender retrieved successfully');
    }

    /**
     * Update the specified Gender in storage.
     * PUT/PATCH /genders/{id}
     *
     * @param int $id
     * @param UpdateGenderAPIRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateGenderAPIRequest $request)
    {
        $input = $request->all();

        /** @var Gender $gender */
        $gender = $this->genderRepository->find($id);

        if (empty($gender)) {
            return $this->sendError('Gender not found');
        }

        $gender = $this->genderRepository->update($input, $id);

        return $this->sendResponse($gender->toArray(), 'Gender updated successfully');
    }

    /**
     * Remove the specified Gender from storage.
     * DELETE /genders/{id}
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var Gender $gender */
        $gender = $this->genderRepository->find($id);

        if (empty($gender)) {
            return $this->sendError('Gender not found');
        }

        $gender->delete();

        return $this->sendSuccess('Gender deleted successfully');
    }
}
