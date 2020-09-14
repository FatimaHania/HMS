<?php namespace Tests\Repositories;

use App\Models\Specialization;
use App\Repositories\SpecializationRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;

class SpecializationRepositoryTest extends TestCase
{
    use ApiTestTrait, DatabaseTransactions;

    /**
     * @var SpecializationRepository
     */
    protected $specializationRepo;

    public function setUp() : void
    {
        parent::setUp();
        $this->specializationRepo = \App::make(SpecializationRepository::class);
    }

    /**
     * @test create
     */
    public function test_create_specialization()
    {
        $specialization = factory(Specialization::class)->make()->toArray();

        $createdSpecialization = $this->specializationRepo->create($specialization);

        $createdSpecialization = $createdSpecialization->toArray();
        $this->assertArrayHasKey('id', $createdSpecialization);
        $this->assertNotNull($createdSpecialization['id'], 'Created Specialization must have id specified');
        $this->assertNotNull(Specialization::find($createdSpecialization['id']), 'Specialization with given id must be in DB');
        $this->assertModelData($specialization, $createdSpecialization);
    }

    /**
     * @test read
     */
    public function test_read_specialization()
    {
        $specialization = factory(Specialization::class)->create();

        $dbSpecialization = $this->specializationRepo->find($specialization->id);

        $dbSpecialization = $dbSpecialization->toArray();
        $this->assertModelData($specialization->toArray(), $dbSpecialization);
    }

    /**
     * @test update
     */
    public function test_update_specialization()
    {
        $specialization = factory(Specialization::class)->create();
        $fakeSpecialization = factory(Specialization::class)->make()->toArray();

        $updatedSpecialization = $this->specializationRepo->update($fakeSpecialization, $specialization->id);

        $this->assertModelData($fakeSpecialization, $updatedSpecialization->toArray());
        $dbSpecialization = $this->specializationRepo->find($specialization->id);
        $this->assertModelData($fakeSpecialization, $dbSpecialization->toArray());
    }

    /**
     * @test delete
     */
    public function test_delete_specialization()
    {
        $specialization = factory(Specialization::class)->create();

        $resp = $this->specializationRepo->delete($specialization->id);

        $this->assertTrue($resp);
        $this->assertNull(Specialization::find($specialization->id), 'Specialization should not exist in DB');
    }
}
