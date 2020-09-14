<?php namespace Tests\Repositories;

use App\Models\Disease;
use App\Repositories\DiseaseRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;

class DiseaseRepositoryTest extends TestCase
{
    use ApiTestTrait, DatabaseTransactions;

    /**
     * @var DiseaseRepository
     */
    protected $diseaseRepo;

    public function setUp() : void
    {
        parent::setUp();
        $this->diseaseRepo = \App::make(DiseaseRepository::class);
    }

    /**
     * @test create
     */
    public function test_create_disease()
    {
        $disease = factory(Disease::class)->make()->toArray();

        $createdDisease = $this->diseaseRepo->create($disease);

        $createdDisease = $createdDisease->toArray();
        $this->assertArrayHasKey('id', $createdDisease);
        $this->assertNotNull($createdDisease['id'], 'Created Disease must have id specified');
        $this->assertNotNull(Disease::find($createdDisease['id']), 'Disease with given id must be in DB');
        $this->assertModelData($disease, $createdDisease);
    }

    /**
     * @test read
     */
    public function test_read_disease()
    {
        $disease = factory(Disease::class)->create();

        $dbDisease = $this->diseaseRepo->find($disease->id);

        $dbDisease = $dbDisease->toArray();
        $this->assertModelData($disease->toArray(), $dbDisease);
    }

    /**
     * @test update
     */
    public function test_update_disease()
    {
        $disease = factory(Disease::class)->create();
        $fakeDisease = factory(Disease::class)->make()->toArray();

        $updatedDisease = $this->diseaseRepo->update($fakeDisease, $disease->id);

        $this->assertModelData($fakeDisease, $updatedDisease->toArray());
        $dbDisease = $this->diseaseRepo->find($disease->id);
        $this->assertModelData($fakeDisease, $dbDisease->toArray());
    }

    /**
     * @test delete
     */
    public function test_delete_disease()
    {
        $disease = factory(Disease::class)->create();

        $resp = $this->diseaseRepo->delete($disease->id);

        $this->assertTrue($resp);
        $this->assertNull(Disease::find($disease->id), 'Disease should not exist in DB');
    }
}
