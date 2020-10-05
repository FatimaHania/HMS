<?php namespace Tests\Repositories;

use App\Models\Room;
use App\Repositories\RoomRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;

class RoomRepositoryTest extends TestCase
{
    use ApiTestTrait, DatabaseTransactions;

    /**
     * @var RoomRepository
     */
    protected $roomRepo;

    public function setUp() : void
    {
        parent::setUp();
        $this->roomRepo = \App::make(RoomRepository::class);
    }

    /**
     * @test create
     */
    public function test_create_room()
    {
        $room = factory(Room::class)->make()->toArray();

        $createdRoom = $this->roomRepo->create($room);

        $createdRoom = $createdRoom->toArray();
        $this->assertArrayHasKey('id', $createdRoom);
        $this->assertNotNull($createdRoom['id'], 'Created Room must have id specified');
        $this->assertNotNull(Room::find($createdRoom['id']), 'Room with given id must be in DB');
        $this->assertModelData($room, $createdRoom);
    }

    /**
     * @test read
     */
    public function test_read_room()
    {
        $room = factory(Room::class)->create();

        $dbRoom = $this->roomRepo->find($room->id);

        $dbRoom = $dbRoom->toArray();
        $this->assertModelData($room->toArray(), $dbRoom);
    }

    /**
     * @test update
     */
    public function test_update_room()
    {
        $room = factory(Room::class)->create();
        $fakeRoom = factory(Room::class)->make()->toArray();

        $updatedRoom = $this->roomRepo->update($fakeRoom, $room->id);

        $this->assertModelData($fakeRoom, $updatedRoom->toArray());
        $dbRoom = $this->roomRepo->find($room->id);
        $this->assertModelData($fakeRoom, $dbRoom->toArray());
    }

    /**
     * @test delete
     */
    public function test_delete_room()
    {
        $room = factory(Room::class)->create();

        $resp = $this->roomRepo->delete($room->id);

        $this->assertTrue($resp);
        $this->assertNull(Room::find($room->id), 'Room should not exist in DB');
    }
}
