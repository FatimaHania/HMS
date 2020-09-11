<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateDocumentCodeRequest;
use App\Http\Requests\UpdateDocumentCodeRequest;
use App\Repositories\DocumentCodeRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Response;

class DocumentCodeController extends AppBaseController
{
    /** @var  DocumentCodeRepository */
    private $documentCodeRepository;

    public function __construct(DocumentCodeRepository $documentCodeRepo)
    {
        $this->documentCodeRepository = $documentCodeRepo;
    }

    /**
     * Display a listing of the DocumentCode.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function index(Request $request)
    {
        $documentCodes = $this->documentCodeRepository->all();

        return view('document_codes.index')
            ->with('documentCodes', $documentCodes);
    }

    /**
     * Show the form for creating a new DocumentCode.
     *
     * @return Response
     */
    public function create()
    {
        return view('document_codes.create');
    }

    /**
     * Store a newly created DocumentCode in storage.
     *
     * @param CreateDocumentCodeRequest $request
     *
     * @return Response
     */
    public function store(CreateDocumentCodeRequest $request)
    {
        $input = $request->all();

        $documentCode = $this->documentCodeRepository->create($input);

        Flash::success('Document Code saved successfully.');

        return redirect(route('documentCodes.index'));
    }

    /**
     * Display the specified DocumentCode.
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $documentCode = $this->documentCodeRepository->find($id);

        if (empty($documentCode)) {
            Flash::error('Document Code not found');

            return redirect(route('documentCodes.index'));
        }

        return view('document_codes.show')->with('documentCode', $documentCode);
    }

    /**
     * Show the form for editing the specified DocumentCode.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $documentCode = $this->documentCodeRepository->find($id);

        if (empty($documentCode)) {
            Flash::error('Document Code not found');

            return redirect(route('documentCodes.index'));
        }

        return view('document_codes.edit')->with('documentCode', $documentCode);
    }

    /**
     * Update the specified DocumentCode in storage.
     *
     * @param int $id
     * @param UpdateDocumentCodeRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateDocumentCodeRequest $request)
    {
        $documentCode = $this->documentCodeRepository->find($id);

        if (empty($documentCode)) {
            Flash::error('Document Code not found');

            return redirect(route('documentCodes.index'));
        }

        $documentCode = $this->documentCodeRepository->update($request->all(), $id);

        Flash::success('Document Code updated successfully.');

        return redirect(route('documentCodes.index'));
    }

    /**
     * Remove the specified DocumentCode from storage.
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        $documentCode = $this->documentCodeRepository->find($id);

        if (empty($documentCode)) {
            Flash::error('Document Code not found');

            return redirect(route('documentCodes.index'));
        }

        $this->documentCodeRepository->delete($id);

        Flash::success('Document Code deleted successfully.');

        return redirect(route('documentCodes.index'));
    }
}
