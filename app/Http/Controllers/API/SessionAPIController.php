<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateSessionAPIRequest;
use App\Http\Requests\API\UpdateSessionAPIRequest;
use App\Models\Session;
use App\Repositories\SessionRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use Response;

/**
 * Class SessionController
 * @package App\Http\Controllers\API
 */

class SessionAPIController extends AppBaseController
{
    /** @var  SessionRepository */
    private $sessionRepository;

    public function __construct(SessionRepository $sessionRepo)
    {
        $this->sessionRepository = $sessionRepo;
    }

    /**
     * Display a listing of the Session.
     * GET|HEAD /sessions
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $sessions = $this->sessionRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

        return $this->sendResponse($sessions->toArray(), 'Sessions retrieved successfully');
    }

    /**
     * Store a newly created Session in storage.
     * POST /sessions
     *
     * @param CreateSessionAPIRequest $request
     *
     * @return Response
     */
    public function store(CreateSessionAPIRequest $request)
    {
        $input = $request->all();

        $session = $this->sessionRepository->create($input);

        return $this->sendResponse($session->toArray(), 'Session saved successfully');
    }

    /**
     * Display the specified Session.
     * GET|HEAD /sessions/{id}
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var Session $session */
        $session = $this->sessionRepository->find($id);

        if (empty($session)) {
            return $this->sendError('Session not found');
        }

        return $this->sendResponse($session->toArray(), 'Session retrieved successfully');
    }

    /**
     * Update the specified Session in storage.
     * PUT/PATCH /sessions/{id}
     *
     * @param int $id
     * @param UpdateSessionAPIRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateSessionAPIRequest $request)
    {
        $input = $request->all();

        /** @var Session $session */
        $session = $this->sessionRepository->find($id);

        if (empty($session)) {
            return $this->sendError('Session not found');
        }

        $session = $this->sessionRepository->update($input, $id);

        return $this->sendResponse($session->toArray(), 'Session updated successfully');
    }

    /**
     * Remove the specified Session from storage.
     * DELETE /sessions/{id}
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var Session $session */
        $session = $this->sessionRepository->find($id);

        if (empty($session)) {
            return $this->sendError('Session not found');
        }

        $session->delete();

        return $this->sendSuccess('Session deleted successfully');
    }
}
