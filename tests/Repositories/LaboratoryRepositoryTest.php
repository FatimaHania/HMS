<?php namespace Tests\Repositories;

use App\Models\Laboratory;
use App\Repositories\LaboratoryRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;

class LaboratoryRepositoryTest extends TestCase
{
    use ApiTestTrait, DatabaseTransactions;

    /**
     * @var LaboratoryRepository
     */
    protected $laboratoryRepo;

    public function setUp() : void
    {
        parent::setUp();
        $this->laboratoryRepo = \App::make(LaboratoryRepository::class);
    }

    /**
     * @test create
     */
    public function test_create_laboratory()
    {
        $laboratory = factory(Laboratory::class)->make()->toArray();

        $createdLaboratory = $this->laboratoryRepo->create($laboratory);

        $createdLaboratory = $createdLaboratory->toArray();
        $this->assertArrayHasKey('id', $createdLaboratory);
        $this->assertNotNull($createdLaboratory['id'], 'Created Laboratory must have id specified');
        $this->assertNotNull(Laboratory::find($createdLaboratory['id']), 'Laboratory with given id must be in DB');
        $this->assertModelData($laboratory, $createdLaboratory);
    }

    /**
     * @test read
     */
    public function test_read_laboratory()
    {
        $laboratory = factory(Laboratory::class)->create();

        $dbLaboratory = $this->laboratoryRepo->find($laboratory->id);

        $dbLaboratory = $dbLaboratory->toArray();
        $this->assertModelData($laboratory->toArray(), $dbLaboratory);
    }

    /**
     * @test update
     */
    public function test_update_laboratory()
    {
        $laboratory = factory(Laboratory::class)->create();
        $fakeLaboratory = factory(Laboratory::class)->make()->toArray();

        $updatedLaboratory = $this->laboratoryRepo->update($fakeLaboratory, $laboratory->id);

        $this->assertModelData($fakeLaboratory, $updatedLaboratory->toArray());
        $dbLaboratory = $this->laboratoryRepo->find($laboratory->id);
        $this->assertModelData($fakeLaboratory, $dbLaboratory->toArray());
    }

    /**
     * @test delete
     */
    public function test_delete_laboratory()
    {
        $laboratory = factory(Laboratory::class)->create();

        $resp = $this->laboratoryRepo->delete($laboratory->id);

        $this->assertTrue($resp);
        $this->assertNull(Laboratory::find($laboratory->id), 'Laboratory should not exist in DB');
    }
}
