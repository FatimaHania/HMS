<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateDocumentCodeAPIRequest;
use App\Http\Requests\API\UpdateDocumentCodeAPIRequest;
use App\Models\DocumentCode;
use App\Repositories\DocumentCodeRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use Response;

/**
 * Class DocumentCodeController
 * @package App\Http\Controllers\API
 */

class DocumentCodeAPIController extends AppBaseController
{
    /** @var  DocumentCodeRepository */
    private $documentCodeRepository;

    public function __construct(DocumentCodeRepository $documentCodeRepo)
    {
        $this->documentCodeRepository = $documentCodeRepo;
    }

    /**
     * Display a listing of the DocumentCode.
     * GET|HEAD /documentCodes
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $documentCodes = $this->documentCodeRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

        return $this->sendResponse($documentCodes->toArray(), 'Document Codes retrieved successfully');
    }

    /**
     * Store a newly created DocumentCode in storage.
     * POST /documentCodes
     *
     * @param CreateDocumentCodeAPIRequest $request
     *
     * @return Response
     */
    public function store(CreateDocumentCodeAPIRequest $request)
    {
        $input = $request->all();

        $documentCode = $this->documentCodeRepository->create($input);

        return $this->sendResponse($documentCode->toArray(), 'Document Code saved successfully');
    }

    /**
     * Display the specified DocumentCode.
     * GET|HEAD /documentCodes/{id}
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var DocumentCode $documentCode */
        $documentCode = $this->documentCodeRepository->find($id);

        if (empty($documentCode)) {
            return $this->sendError('Document Code not found');
        }

        return $this->sendResponse($documentCode->toArray(), 'Document Code retrieved successfully');
    }

    /**
     * Update the specified DocumentCode in storage.
     * PUT/PATCH /documentCodes/{id}
     *
     * @param int $id
     * @param UpdateDocumentCodeAPIRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateDocumentCodeAPIRequest $request)
    {
        $input = $request->all();

        /** @var DocumentCode $documentCode */
        $documentCode = $this->documentCodeRepository->find($id);

        if (empty($documentCode)) {
            return $this->sendError('Document Code not found');
        }

        $documentCode = $this->documentCodeRepository->update($input, $id);

        return $this->sendResponse($documentCode->toArray(), 'DocumentCode updated successfully');
    }

    /**
     * Remove the specified DocumentCode from storage.
     * DELETE /documentCodes/{id}
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var DocumentCode $documentCode */
        $documentCode = $this->documentCodeRepository->find($id);

        if (empty($documentCode)) {
            return $this->sendError('Document Code not found');
        }

        $documentCode->delete();

        return $this->sendSuccess('Document Code deleted successfully');
    }
}
