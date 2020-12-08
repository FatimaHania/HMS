<?php namespace Tests\APIs;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\Usergroup;

class UsergroupApiTest extends TestCase
{
    use ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function test_create_usergroup()
    {
        $usergroup = factory(Usergroup::class)->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/usergroups', $usergroup
        );

        $this->assertApiResponse($usergroup);
    }

    /**
     * @test
     */
    public function test_read_usergroup()
    {
        $usergroup = factory(Usergroup::class)->create();

        $this->response = $this->json(
            'GET',
            '/api/usergroups/'.$usergroup->id
        );

        $this->assertApiResponse($usergroup->toArray());
    }

    /**
     * @test
     */
    public function test_update_usergroup()
    {
        $usergroup = factory(Usergroup::class)->create();
        $editedUsergroup = factory(Usergroup::class)->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/usergroups/'.$usergroup->id,
            $editedUsergroup
        );

        $this->assertApiResponse($editedUsergroup);
    }

    /**
     * @test
     */
    public function test_delete_usergroup()
    {
        $usergroup = factory(Usergroup::class)->create();

        $this->response = $this->json(
            'DELETE',
             '/api/usergroups/'.$usergroup->id
         );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/usergroups/'.$usergroup->id
        );

        $this->response->assertStatus(404);
    }
}
