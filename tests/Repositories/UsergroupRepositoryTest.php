<?php namespace Tests\Repositories;

use App\Models\Usergroup;
use App\Repositories\UsergroupRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;

class UsergroupRepositoryTest extends TestCase
{
    use ApiTestTrait, DatabaseTransactions;

    /**
     * @var UsergroupRepository
     */
    protected $usergroupRepo;

    public function setUp() : void
    {
        parent::setUp();
        $this->usergroupRepo = \App::make(UsergroupRepository::class);
    }

    /**
     * @test create
     */
    public function test_create_usergroup()
    {
        $usergroup = factory(Usergroup::class)->make()->toArray();

        $createdUsergroup = $this->usergroupRepo->create($usergroup);

        $createdUsergroup = $createdUsergroup->toArray();
        $this->assertArrayHasKey('id', $createdUsergroup);
        $this->assertNotNull($createdUsergroup['id'], 'Created Usergroup must have id specified');
        $this->assertNotNull(Usergroup::find($createdUsergroup['id']), 'Usergroup with given id must be in DB');
        $this->assertModelData($usergroup, $createdUsergroup);
    }

    /**
     * @test read
     */
    public function test_read_usergroup()
    {
        $usergroup = factory(Usergroup::class)->create();

        $dbUsergroup = $this->usergroupRepo->find($usergroup->id);

        $dbUsergroup = $dbUsergroup->toArray();
        $this->assertModelData($usergroup->toArray(), $dbUsergroup);
    }

    /**
     * @test update
     */
    public function test_update_usergroup()
    {
        $usergroup = factory(Usergroup::class)->create();
        $fakeUsergroup = factory(Usergroup::class)->make()->toArray();

        $updatedUsergroup = $this->usergroupRepo->update($fakeUsergroup, $usergroup->id);

        $this->assertModelData($fakeUsergroup, $updatedUsergroup->toArray());
        $dbUsergroup = $this->usergroupRepo->find($usergroup->id);
        $this->assertModelData($fakeUsergroup, $dbUsergroup->toArray());
    }

    /**
     * @test delete
     */
    public function test_delete_usergroup()
    {
        $usergroup = factory(Usergroup::class)->create();

        $resp = $this->usergroupRepo->delete($usergroup->id);

        $this->assertTrue($resp);
        $this->assertNull(Usergroup::find($usergroup->id), 'Usergroup should not exist in DB');
    }
}
