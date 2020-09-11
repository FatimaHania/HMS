<?php namespace Tests\APIs;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\DocumentCode;

class DocumentCodeApiTest extends TestCase
{
    use ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function test_create_document_code()
    {
        $documentCode = factory(DocumentCode::class)->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/document_codes', $documentCode
        );

        $this->assertApiResponse($documentCode);
    }

    /**
     * @test
     */
    public function test_read_document_code()
    {
        $documentCode = factory(DocumentCode::class)->create();

        $this->response = $this->json(
            'GET',
            '/api/document_codes/'.$documentCode->id
        );

        $this->assertApiResponse($documentCode->toArray());
    }

    /**
     * @test
     */
    public function test_update_document_code()
    {
        $documentCode = factory(DocumentCode::class)->create();
        $editedDocumentCode = factory(DocumentCode::class)->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/document_codes/'.$documentCode->id,
            $editedDocumentCode
        );

        $this->assertApiResponse($editedDocumentCode);
    }

    /**
     * @test
     */
    public function test_delete_document_code()
    {
        $documentCode = factory(DocumentCode::class)->create();

        $this->response = $this->json(
            'DELETE',
             '/api/document_codes/'.$documentCode->id
         );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/document_codes/'.$documentCode->id
        );

        $this->response->assertStatus(404);
    }
}
