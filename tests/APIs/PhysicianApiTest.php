<?php namespace Tests\APIs;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\Physician;

class PhysicianApiTest extends TestCase
{
    use ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function test_create_physician()
    {
        $physician = factory(Physician::class)->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/physicians', $physician
        );

        $this->assertApiResponse($physician);
    }

    /**
     * @test
     */
    public function test_read_physician()
    {
        $physician = factory(Physician::class)->create();

        $this->response = $this->json(
            'GET',
            '/api/physicians/'.$physician->id
        );

        $this->assertApiResponse($physician->toArray());
    }

    /**
     * @test
     */
    public function test_update_physician()
    {
        $physician = factory(Physician::class)->create();
        $editedPhysician = factory(Physician::class)->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/physicians/'.$physician->id,
            $editedPhysician
        );

        $this->assertApiResponse($editedPhysician);
    }

    /**
     * @test
     */
    public function test_delete_physician()
    {
        $physician = factory(Physician::class)->create();

        $this->response = $this->json(
            'DELETE',
             '/api/physicians/'.$physician->id
         );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/physicians/'.$physician->id
        );

        $this->response->assertStatus(404);
    }
}
