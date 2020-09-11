<?php namespace Tests\APIs;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\Bloodgroup;

class BloodgroupApiTest extends TestCase
{
    use ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function test_create_bloodgroup()
    {
        $bloodgroup = factory(Bloodgroup::class)->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/bloodgroups', $bloodgroup
        );

        $this->assertApiResponse($bloodgroup);
    }

    /**
     * @test
     */
    public function test_read_bloodgroup()
    {
        $bloodgroup = factory(Bloodgroup::class)->create();

        $this->response = $this->json(
            'GET',
            '/api/bloodgroups/'.$bloodgroup->id
        );

        $this->assertApiResponse($bloodgroup->toArray());
    }

    /**
     * @test
     */
    public function test_update_bloodgroup()
    {
        $bloodgroup = factory(Bloodgroup::class)->create();
        $editedBloodgroup = factory(Bloodgroup::class)->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/bloodgroups/'.$bloodgroup->id,
            $editedBloodgroup
        );

        $this->assertApiResponse($editedBloodgroup);
    }

    /**
     * @test
     */
    public function test_delete_bloodgroup()
    {
        $bloodgroup = factory(Bloodgroup::class)->create();

        $this->response = $this->json(
            'DELETE',
             '/api/bloodgroups/'.$bloodgroup->id
         );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/bloodgroups/'.$bloodgroup->id
        );

        $this->response->assertStatus(404);
    }
}
