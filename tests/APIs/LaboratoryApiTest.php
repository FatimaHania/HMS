<?php namespace Tests\APIs;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\Laboratory;

class LaboratoryApiTest extends TestCase
{
    use ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function test_create_laboratory()
    {
        $laboratory = factory(Laboratory::class)->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/laboratories', $laboratory
        );

        $this->assertApiResponse($laboratory);
    }

    /**
     * @test
     */
    public function test_read_laboratory()
    {
        $laboratory = factory(Laboratory::class)->create();

        $this->response = $this->json(
            'GET',
            '/api/laboratories/'.$laboratory->id
        );

        $this->assertApiResponse($laboratory->toArray());
    }

    /**
     * @test
     */
    public function test_update_laboratory()
    {
        $laboratory = factory(Laboratory::class)->create();
        $editedLaboratory = factory(Laboratory::class)->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/laboratories/'.$laboratory->id,
            $editedLaboratory
        );

        $this->assertApiResponse($editedLaboratory);
    }

    /**
     * @test
     */
    public function test_delete_laboratory()
    {
        $laboratory = factory(Laboratory::class)->create();

        $this->response = $this->json(
            'DELETE',
             '/api/laboratories/'.$laboratory->id
         );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/laboratories/'.$laboratory->id
        );

        $this->response->assertStatus(404);
    }
}
