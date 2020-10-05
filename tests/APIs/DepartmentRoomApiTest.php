<?php namespace Tests\APIs;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\DepartmentRoom;

class DepartmentRoomApiTest extends TestCase
{
    use ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function test_create_department_room()
    {
        $departmentRoom = factory(DepartmentRoom::class)->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/department_rooms', $departmentRoom
        );

        $this->assertApiResponse($departmentRoom);
    }

    /**
     * @test
     */
    public function test_read_department_room()
    {
        $departmentRoom = factory(DepartmentRoom::class)->create();

        $this->response = $this->json(
            'GET',
            '/api/department_rooms/'.$departmentRoom->id
        );

        $this->assertApiResponse($departmentRoom->toArray());
    }

    /**
     * @test
     */
    public function test_update_department_room()
    {
        $departmentRoom = factory(DepartmentRoom::class)->create();
        $editedDepartmentRoom = factory(DepartmentRoom::class)->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/department_rooms/'.$departmentRoom->id,
            $editedDepartmentRoom
        );

        $this->assertApiResponse($editedDepartmentRoom);
    }

    /**
     * @test
     */
    public function test_delete_department_room()
    {
        $departmentRoom = factory(DepartmentRoom::class)->create();

        $this->response = $this->json(
            'DELETE',
             '/api/department_rooms/'.$departmentRoom->id
         );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/department_rooms/'.$departmentRoom->id
        );

        $this->response->assertStatus(404);
    }
}
