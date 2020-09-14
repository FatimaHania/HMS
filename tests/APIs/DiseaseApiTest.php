<?php namespace Tests\APIs;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\Disease;

class DiseaseApiTest extends TestCase
{
    use ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function test_create_disease()
    {
        $disease = factory(Disease::class)->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/diseases', $disease
        );

        $this->assertApiResponse($disease);
    }

    /**
     * @test
     */
    public function test_read_disease()
    {
        $disease = factory(Disease::class)->create();

        $this->response = $this->json(
            'GET',
            '/api/diseases/'.$disease->id
        );

        $this->assertApiResponse($disease->toArray());
    }

    /**
     * @test
     */
    public function test_update_disease()
    {
        $disease = factory(Disease::class)->create();
        $editedDisease = factory(Disease::class)->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/diseases/'.$disease->id,
            $editedDisease
        );

        $this->assertApiResponse($editedDisease);
    }

    /**
     * @test
     */
    public function test_delete_disease()
    {
        $disease = factory(Disease::class)->create();

        $this->response = $this->json(
            'DELETE',
             '/api/diseases/'.$disease->id
         );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/diseases/'.$disease->id
        );

        $this->response->assertStatus(404);
    }
}
