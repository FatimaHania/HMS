<?php namespace Tests\Repositories;

use App\Models\Nationality;
use App\Repositories\NationalityRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;

class NationalityRepositoryTest extends TestCase
{
    use ApiTestTrait, DatabaseTransactions;

    /**
     * @var NationalityRepository
     */
    protected $nationalityRepo;

    public function setUp() : void
    {
        parent::setUp();
        $this->nationalityRepo = \App::make(NationalityRepository::class);
    }

    /**
     * @test create
     */
    public function test_create_nationality()
    {
        $nationality = factory(Nationality::class)->make()->toArray();

        $createdNationality = $this->nationalityRepo->create($nationality);

        $createdNationality = $createdNationality->toArray();
        $this->assertArrayHasKey('id', $createdNationality);
        $this->assertNotNull($createdNationality['id'], 'Created Nationality must have id specified');
        $this->assertNotNull(Nationality::find($createdNationality['id']), 'Nationality with given id must be in DB');
        $this->assertModelData($nationality, $createdNationality);
    }

    /**
     * @test read
     */
    public function test_read_nationality()
    {
        $nationality = factory(Nationality::class)->create();

        $dbNationality = $this->nationalityRepo->find($nationality->id);

        $dbNationality = $dbNationality->toArray();
        $this->assertModelData($nationality->toArray(), $dbNationality);
    }

    /**
     * @test update
     */
    public function test_update_nationality()
    {
        $nationality = factory(Nationality::class)->create();
        $fakeNationality = factory(Nationality::class)->make()->toArray();

        $updatedNationality = $this->nationalityRepo->update($fakeNationality, $nationality->id);

        $this->assertModelData($fakeNationality, $updatedNationality->toArray());
        $dbNationality = $this->nationalityRepo->find($nationality->id);
        $this->assertModelData($fakeNationality, $dbNationality->toArray());
    }

    /**
     * @test delete
     */
    public function test_delete_nationality()
    {
        $nationality = factory(Nationality::class)->create();

        $resp = $this->nationalityRepo->delete($nationality->id);

        $this->assertTrue($resp);
        $this->assertNull(Nationality::find($nationality->id), 'Nationality should not exist in DB');
    }
}
