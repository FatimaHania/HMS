<?php namespace Tests\Repositories;

use App\Models\Bloodgroup;
use App\Repositories\BloodgroupRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;

class BloodgroupRepositoryTest extends TestCase
{
    use ApiTestTrait, DatabaseTransactions;

    /**
     * @var BloodgroupRepository
     */
    protected $bloodgroupRepo;

    public function setUp() : void
    {
        parent::setUp();
        $this->bloodgroupRepo = \App::make(BloodgroupRepository::class);
    }

    /**
     * @test create
     */
    public function test_create_bloodgroup()
    {
        $bloodgroup = factory(Bloodgroup::class)->make()->toArray();

        $createdBloodgroup = $this->bloodgroupRepo->create($bloodgroup);

        $createdBloodgroup = $createdBloodgroup->toArray();
        $this->assertArrayHasKey('id', $createdBloodgroup);
        $this->assertNotNull($createdBloodgroup['id'], 'Created Bloodgroup must have id specified');
        $this->assertNotNull(Bloodgroup::find($createdBloodgroup['id']), 'Bloodgroup with given id must be in DB');
        $this->assertModelData($bloodgroup, $createdBloodgroup);
    }

    /**
     * @test read
     */
    public function test_read_bloodgroup()
    {
        $bloodgroup = factory(Bloodgroup::class)->create();

        $dbBloodgroup = $this->bloodgroupRepo->find($bloodgroup->id);

        $dbBloodgroup = $dbBloodgroup->toArray();
        $this->assertModelData($bloodgroup->toArray(), $dbBloodgroup);
    }

    /**
     * @test update
     */
    public function test_update_bloodgroup()
    {
        $bloodgroup = factory(Bloodgroup::class)->create();
        $fakeBloodgroup = factory(Bloodgroup::class)->make()->toArray();

        $updatedBloodgroup = $this->bloodgroupRepo->update($fakeBloodgroup, $bloodgroup->id);

        $this->assertModelData($fakeBloodgroup, $updatedBloodgroup->toArray());
        $dbBloodgroup = $this->bloodgroupRepo->find($bloodgroup->id);
        $this->assertModelData($fakeBloodgroup, $dbBloodgroup->toArray());
    }

    /**
     * @test delete
     */
    public function test_delete_bloodgroup()
    {
        $bloodgroup = factory(Bloodgroup::class)->create();

        $resp = $this->bloodgroupRepo->delete($bloodgroup->id);

        $this->assertTrue($resp);
        $this->assertNull(Bloodgroup::find($bloodgroup->id), 'Bloodgroup should not exist in DB');
    }
}
