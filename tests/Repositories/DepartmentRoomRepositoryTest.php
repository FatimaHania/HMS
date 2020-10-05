<?php namespace Tests\Repositories;

use App\Models\DepartmentRoom;
use App\Repositories\DepartmentRoomRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;

class DepartmentRoomRepositoryTest extends TestCase
{
    use ApiTestTrait, DatabaseTransactions;

    /**
     * @var DepartmentRoomRepository
     */
    protected $departmentRoomRepo;

    public function setUp() : void
    {
        parent::setUp();
        $this->departmentRoomRepo = \App::make(DepartmentRoomRepository::class);
    }

    /**
     * @test create
     */
    public function test_create_department_room()
    {
        $departmentRoom = factory(DepartmentRoom::class)->make()->toArray();

        $createdDepartmentRoom = $this->departmentRoomRepo->create($departmentRoom);

        $createdDepartmentRoom = $createdDepartmentRoom->toArray();
        $this->assertArrayHasKey('id', $createdDepartmentRoom);
        $this->assertNotNull($createdDepartmentRoom['id'], 'Created DepartmentRoom must have id specified');
        $this->assertNotNull(DepartmentRoom::find($createdDepartmentRoom['id']), 'DepartmentRoom with given id must be in DB');
        $this->assertModelData($departmentRoom, $createdDepartmentRoom);
    }

    /**
     * @test read
     */
    public function test_read_department_room()
    {
        $departmentRoom = factory(DepartmentRoom::class)->create();

        $dbDepartmentRoom = $this->departmentRoomRepo->find($departmentRoom->id);

        $dbDepartmentRoom = $dbDepartmentRoom->toArray();
        $this->assertModelData($departmentRoom->toArray(), $dbDepartmentRoom);
    }

    /**
     * @test update
     */
    public function test_update_department_room()
    {
        $departmentRoom = factory(DepartmentRoom::class)->create();
        $fakeDepartmentRoom = factory(DepartmentRoom::class)->make()->toArray();

        $updatedDepartmentRoom = $this->departmentRoomRepo->update($fakeDepartmentRoom, $departmentRoom->id);

        $this->assertModelData($fakeDepartmentRoom, $updatedDepartmentRoom->toArray());
        $dbDepartmentRoom = $this->departmentRoomRepo->find($departmentRoom->id);
        $this->assertModelData($fakeDepartmentRoom, $dbDepartmentRoom->toArray());
    }

    /**
     * @test delete
     */
    public function test_delete_department_room()
    {
        $departmentRoom = factory(DepartmentRoom::class)->create();

        $resp = $this->departmentRoomRepo->delete($departmentRoom->id);

        $this->assertTrue($resp);
        $this->assertNull(DepartmentRoom::find($departmentRoom->id), 'DepartmentRoom should not exist in DB');
    }
}
