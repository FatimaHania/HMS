<?php namespace Tests\Repositories;

use App\Models\Nurse;
use App\Repositories\NurseRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;

class NurseRepositoryTest extends TestCase
{
    use ApiTestTrait, DatabaseTransactions;

    /**
     * @var NurseRepository
     */
    protected $nurseRepo;

    public function setUp() : void
    {
        parent::setUp();
        $this->nurseRepo = \App::make(NurseRepository::class);
    }

    /**
     * @test create
     */
    public function test_create_nurse()
    {
        $nurse = factory(Nurse::class)->make()->toArray();

        $createdNurse = $this->nurseRepo->create($nurse);

        $createdNurse = $createdNurse->toArray();
        $this->assertArrayHasKey('id', $createdNurse);
        $this->assertNotNull($createdNurse['id'], 'Created Nurse must have id specified');
        $this->assertNotNull(Nurse::find($createdNurse['id']), 'Nurse with given id must be in DB');
        $this->assertModelData($nurse, $createdNurse);
    }

    /**
     * @test read
     */
    public function test_read_nurse()
    {
        $nurse = factory(Nurse::class)->create();

        $dbNurse = $this->nurseRepo->find($nurse->id);

        $dbNurse = $dbNurse->toArray();
        $this->assertModelData($nurse->toArray(), $dbNurse);
    }

    /**
     * @test update
     */
    public function test_update_nurse()
    {
        $nurse = factory(Nurse::class)->create();
        $fakeNurse = factory(Nurse::class)->make()->toArray();

        $updatedNurse = $this->nurseRepo->update($fakeNurse, $nurse->id);

        $this->assertModelData($fakeNurse, $updatedNurse->toArray());
        $dbNurse = $this->nurseRepo->find($nurse->id);
        $this->assertModelData($fakeNurse, $dbNurse->toArray());
    }

    /**
     * @test delete
     */
    public function test_delete_nurse()
    {
        $nurse = factory(Nurse::class)->create();

        $resp = $this->nurseRepo->delete($nurse->id);

        $this->assertTrue($resp);
        $this->assertNull(Nurse::find($nurse->id), 'Nurse should not exist in DB');
    }
}
