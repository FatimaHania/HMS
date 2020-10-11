<?php namespace Tests\APIs;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\Session;

class SessionApiTest extends TestCase
{
    use ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function test_create_session()
    {
        $session = factory(Session::class)->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/sessions', $session
        );

        $this->assertApiResponse($session);
    }

    /**
     * @test
     */
    public function test_read_session()
    {
        $session = factory(Session::class)->create();

        $this->response = $this->json(
            'GET',
            '/api/sessions/'.$session->id
        );

        $this->assertApiResponse($session->toArray());
    }

    /**
     * @test
     */
    public function test_update_session()
    {
        $session = factory(Session::class)->create();
        $editedSession = factory(Session::class)->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/sessions/'.$session->id,
            $editedSession
        );

        $this->assertApiResponse($editedSession);
    }

    /**
     * @test
     */
    public function test_delete_session()
    {
        $session = factory(Session::class)->create();

        $this->response = $this->json(
            'DELETE',
             '/api/sessions/'.$session->id
         );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/sessions/'.$session->id
        );

        $this->response->assertStatus(404);
    }
}
