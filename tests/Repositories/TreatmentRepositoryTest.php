<?php namespace Tests\Repositories;

use App\Models\Treatment;
use App\Repositories\TreatmentRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;

class TreatmentRepositoryTest extends TestCase
{
    use ApiTestTrait, DatabaseTransactions;

    /**
     * @var TreatmentRepository
     */
    protected $treatmentRepo;

    public function setUp() : void
    {
        parent::setUp();
        $this->treatmentRepo = \App::make(TreatmentRepository::class);
    }

    /**
     * @test create
     */
    public function test_create_treatment()
    {
        $treatment = factory(Treatment::class)->make()->toArray();

        $createdTreatment = $this->treatmentRepo->create($treatment);

        $createdTreatment = $createdTreatment->toArray();
        $this->assertArrayHasKey('id', $createdTreatment);
        $this->assertNotNull($createdTreatment['id'], 'Created Treatment must have id specified');
        $this->assertNotNull(Treatment::find($createdTreatment['id']), 'Treatment with given id must be in DB');
        $this->assertModelData($treatment, $createdTreatment);
    }

    /**
     * @test read
     */
    public function test_read_treatment()
    {
        $treatment = factory(Treatment::class)->create();

        $dbTreatment = $this->treatmentRepo->find($treatment->id);

        $dbTreatment = $dbTreatment->toArray();
        $this->assertModelData($treatment->toArray(), $dbTreatment);
    }

    /**
     * @test update
     */
    public function test_update_treatment()
    {
        $treatment = factory(Treatment::class)->create();
        $fakeTreatment = factory(Treatment::class)->make()->toArray();

        $updatedTreatment = $this->treatmentRepo->update($fakeTreatment, $treatment->id);

        $this->assertModelData($fakeTreatment, $updatedTreatment->toArray());
        $dbTreatment = $this->treatmentRepo->find($treatment->id);
        $this->assertModelData($fakeTreatment, $dbTreatment->toArray());
    }

    /**
     * @test delete
     */
    public function test_delete_treatment()
    {
        $treatment = factory(Treatment::class)->create();

        $resp = $this->treatmentRepo->delete($treatment->id);

        $this->assertTrue($resp);
        $this->assertNull(Treatment::find($treatment->id), 'Treatment should not exist in DB');
    }
}
