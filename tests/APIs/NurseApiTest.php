<?php namespace Tests\APIs;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\Nurse;

class NurseApiTest extends TestCase
{
    use ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function test_create_nurse()
    {
        $nurse = factory(Nurse::class)->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/nurses', $nurse
        );

        $this->assertApiResponse($nurse);
    }

    /**
     * @test
     */
    public function test_read_nurse()
    {
        $nurse = factory(Nurse::class)->create();

        $this->response = $this->json(
            'GET',
            '/api/nurses/'.$nurse->id
        );

        $this->assertApiResponse($nurse->toArray());
    }

    /**
     * @test
     */
    public function test_update_nurse()
    {
        $nurse = factory(Nurse::class)->create();
        $editedNurse = factory(Nurse::class)->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/nurses/'.$nurse->id,
            $editedNurse
        );

        $this->assertApiResponse($editedNurse);
    }

    /**
     * @test
     */
    public function test_delete_nurse()
    {
        $nurse = factory(Nurse::class)->create();

        $this->response = $this->json(
            'DELETE',
             '/api/nurses/'.$nurse->id
         );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/nurses/'.$nurse->id
        );

        $this->response->assertStatus(404);
    }
}
