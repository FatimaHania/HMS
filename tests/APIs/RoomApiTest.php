<?php namespace Tests\APIs;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\Room;

class RoomApiTest extends TestCase
{
    use ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function test_create_room()
    {
        $room = factory(Room::class)->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/rooms', $room
        );

        $this->assertApiResponse($room);
    }

    /**
     * @test
     */
    public function test_read_room()
    {
        $room = factory(Room::class)->create();

        $this->response = $this->json(
            'GET',
            '/api/rooms/'.$room->id
        );

        $this->assertApiResponse($room->toArray());
    }

    /**
     * @test
     */
    public function test_update_room()
    {
        $room = factory(Room::class)->create();
        $editedRoom = factory(Room::class)->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/rooms/'.$room->id,
            $editedRoom
        );

        $this->assertApiResponse($editedRoom);
    }

    /**
     * @test
     */
    public function test_delete_room()
    {
        $room = factory(Room::class)->create();

        $this->response = $this->json(
            'DELETE',
             '/api/rooms/'.$room->id
         );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/rooms/'.$room->id
        );

        $this->response->assertStatus(404);
    }
}
