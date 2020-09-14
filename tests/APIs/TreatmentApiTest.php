<?php namespace Tests\APIs;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\Treatment;

class TreatmentApiTest extends TestCase
{
    use ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function test_create_treatment()
    {
        $treatment = factory(Treatment::class)->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/treatments', $treatment
        );

        $this->assertApiResponse($treatment);
    }

    /**
     * @test
     */
    public function test_read_treatment()
    {
        $treatment = factory(Treatment::class)->create();

        $this->response = $this->json(
            'GET',
            '/api/treatments/'.$treatment->id
        );

        $this->assertApiResponse($treatment->toArray());
    }

    /**
     * @test
     */
    public function test_update_treatment()
    {
        $treatment = factory(Treatment::class)->create();
        $editedTreatment = factory(Treatment::class)->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/treatments/'.$treatment->id,
            $editedTreatment
        );

        $this->assertApiResponse($editedTreatment);
    }

    /**
     * @test
     */
    public function test_delete_treatment()
    {
        $treatment = factory(Treatment::class)->create();

        $this->response = $this->json(
            'DELETE',
             '/api/treatments/'.$treatment->id
         );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/treatments/'.$treatment->id
        );

        $this->response->assertStatus(404);
    }
}
