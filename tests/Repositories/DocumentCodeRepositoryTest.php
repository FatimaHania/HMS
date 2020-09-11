<?php namespace Tests\Repositories;

use App\Models\DocumentCode;
use App\Repositories\DocumentCodeRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;

class DocumentCodeRepositoryTest extends TestCase
{
    use ApiTestTrait, DatabaseTransactions;

    /**
     * @var DocumentCodeRepository
     */
    protected $documentCodeRepo;

    public function setUp() : void
    {
        parent::setUp();
        $this->documentCodeRepo = \App::make(DocumentCodeRepository::class);
    }

    /**
     * @test create
     */
    public function test_create_document_code()
    {
        $documentCode = factory(DocumentCode::class)->make()->toArray();

        $createdDocumentCode = $this->documentCodeRepo->create($documentCode);

        $createdDocumentCode = $createdDocumentCode->toArray();
        $this->assertArrayHasKey('id', $createdDocumentCode);
        $this->assertNotNull($createdDocumentCode['id'], 'Created DocumentCode must have id specified');
        $this->assertNotNull(DocumentCode::find($createdDocumentCode['id']), 'DocumentCode with given id must be in DB');
        $this->assertModelData($documentCode, $createdDocumentCode);
    }

    /**
     * @test read
     */
    public function test_read_document_code()
    {
        $documentCode = factory(DocumentCode::class)->create();

        $dbDocumentCode = $this->documentCodeRepo->find($documentCode->id);

        $dbDocumentCode = $dbDocumentCode->toArray();
        $this->assertModelData($documentCode->toArray(), $dbDocumentCode);
    }

    /**
     * @test update
     */
    public function test_update_document_code()
    {
        $documentCode = factory(DocumentCode::class)->create();
        $fakeDocumentCode = factory(DocumentCode::class)->make()->toArray();

        $updatedDocumentCode = $this->documentCodeRepo->update($fakeDocumentCode, $documentCode->id);

        $this->assertModelData($fakeDocumentCode, $updatedDocumentCode->toArray());
        $dbDocumentCode = $this->documentCodeRepo->find($documentCode->id);
        $this->assertModelData($fakeDocumentCode, $dbDocumentCode->toArray());
    }

    /**
     * @test delete
     */
    public function test_delete_document_code()
    {
        $documentCode = factory(DocumentCode::class)->create();

        $resp = $this->documentCodeRepo->delete($documentCode->id);

        $this->assertTrue($resp);
        $this->assertNull(DocumentCode::find($documentCode->id), 'DocumentCode should not exist in DB');
    }
}
