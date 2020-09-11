<?php namespace Tests\Repositories;

use App\Models\Physician;
use App\Repositories\PhysicianRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;

class PhysicianRepositoryTest extends TestCase
{
    use ApiTestTrait, DatabaseTransactions;

    /**
     * @var PhysicianRepository
     */
    protected $physicianRepo;

    public function setUp() : void
    {
        parent::setUp();
        $this->physicianRepo = \App::make(PhysicianRepository::class);
    }

    /**
     * @test create
     */
    public function test_create_physician()
    {
        $physician = factory(Physician::class)->make()->toArray();

        $createdPhysician = $this->physicianRepo->create($physician);

        $createdPhysician = $createdPhysician->toArray();
        $this->assertArrayHasKey('id', $createdPhysician);
        $this->assertNotNull($createdPhysician['id'], 'Created Physician must have id specified');
        $this->assertNotNull(Physician::find($createdPhysician['id']), 'Physician with given id must be in DB');
        $this->assertModelData($physician, $createdPhysician);
    }

    /**
     * @test read
     */
    public function test_read_physician()
    {
        $physician = factory(Physician::class)->create();

        $dbPhysician = $this->physicianRepo->find($physician->id);

        $dbPhysician = $dbPhysician->toArray();
        $this->assertModelData($physician->toArray(), $dbPhysician);
    }

    /**
     * @test update
     */
    public function test_update_physician()
    {
        $physician = factory(Physician::class)->create();
        $fakePhysician = factory(Physician::class)->make()->toArray();

        $updatedPhysician = $this->physicianRepo->update($fakePhysician, $physician->id);

        $this->assertModelData($fakePhysician, $updatedPhysician->toArray());
        $dbPhysician = $this->physicianRepo->find($physician->id);
        $this->assertModelData($fakePhysician, $dbPhysician->toArray());
    }

    /**
     * @test delete
     */
    public function test_delete_physician()
    {
        $physician = factory(Physician::class)->create();

        $resp = $this->physicianRepo->delete($physician->id);

        $this->assertTrue($resp);
        $this->assertNull(Physician::find($physician->id), 'Physician should not exist in DB');
    }
}
