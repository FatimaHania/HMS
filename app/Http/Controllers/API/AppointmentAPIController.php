<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateAppointmentAPIRequest;
use App\Http\Requests\API\UpdateAppointmentAPIRequest;
use App\Models\Appointment;
use App\Repositories\AppointmentRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use Response;

/**
 * Class AppointmentController
 * @package App\Http\Controllers\API
 */

class AppointmentAPIController extends AppBaseController
{
    /** @var  AppointmentRepository */
    private $appointmentRepository;

    public function __construct(AppointmentRepository $appointmentRepo)
    {
        $this->appointmentRepository = $appointmentRepo;
    }

    /**
     * Display a listing of the Appointment.
     * GET|HEAD /appointments
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $appointments = $this->appointmentRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

        return $this->sendResponse($appointments->toArray(), 'Appointments retrieved successfully');
    }

    /**
     * Store a newly created Appointment in storage.
     * POST /appointments
     *
     * @param CreateAppointmentAPIRequest $request
     *
     * @return Response
     */
    public function store(CreateAppointmentAPIRequest $request)
    {
        $input = $request->all();

        $appointment = $this->appointmentRepository->create($input);

        return $this->sendResponse($appointment->toArray(), 'Appointment saved successfully');
    }

    /**
     * Display the specified Appointment.
     * GET|HEAD /appointments/{id}
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var Appointment $appointment */
        $appointment = $this->appointmentRepository->find($id);

        if (empty($appointment)) {
            return $this->sendError('Appointment not found');
        }

        return $this->sendResponse($appointment->toArray(), 'Appointment retrieved successfully');
    }

    /**
     * Update the specified Appointment in storage.
     * PUT/PATCH /appointments/{id}
     *
     * @param int $id
     * @param UpdateAppointmentAPIRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateAppointmentAPIRequest $request)
    {
        $input = $request->all();

        /** @var Appointment $appointment */
        $appointment = $this->appointmentRepository->find($id);

        if (empty($appointment)) {
            return $this->sendError('Appointment not found');
        }

        $appointment = $this->appointmentRepository->update($input, $id);

        return $this->sendResponse($appointment->toArray(), 'Appointment updated successfully');
    }

    /**
     * Remove the specified Appointment from storage.
     * DELETE /appointments/{id}
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var Appointment $appointment */
        $appointment = $this->appointmentRepository->find($id);

        if (empty($appointment)) {
            return $this->sendError('Appointment not found');
        }

        $appointment->delete();

        return $this->sendSuccess('Appointment deleted successfully');
    }
}
