<?php namespace Tests\Repositories;

use App\Models\Session;
use App\Repositories\SessionRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;

class SessionRepositoryTest extends TestCase
{
    use ApiTestTrait, DatabaseTransactions;

    /**
     * @var SessionRepository
     */
    protected $sessionRepo;

    public function setUp() : void
    {
        parent::setUp();
        $this->sessionRepo = \App::make(SessionRepository::class);
    }

    /**
     * @test create
     */
    public function test_create_session()
    {
        $session = factory(Session::class)->make()->toArray();

        $createdSession = $this->sessionRepo->create($session);

        $createdSession = $createdSession->toArray();
        $this->assertArrayHasKey('id', $createdSession);
        $this->assertNotNull($createdSession['id'], 'Created Session must have id specified');
        $this->assertNotNull(Session::find($createdSession['id']), 'Session with given id must be in DB');
        $this->assertModelData($session, $createdSession);
    }

    /**
     * @test read
     */
    public function test_read_session()
    {
        $session = factory(Session::class)->create();

        $dbSession = $this->sessionRepo->find($session->id);

        $dbSession = $dbSession->toArray();
        $this->assertModelData($session->toArray(), $dbSession);
    }

    /**
     * @test update
     */
    public function test_update_session()
    {
        $session = factory(Session::class)->create();
        $fakeSession = factory(Session::class)->make()->toArray();

        $updatedSession = $this->sessionRepo->update($fakeSession, $session->id);

        $this->assertModelData($fakeSession, $updatedSession->toArray());
        $dbSession = $this->sessionRepo->find($session->id);
        $this->assertModelData($fakeSession, $dbSession->toArray());
    }

    /**
     * @test delete
     */
    public function test_delete_session()
    {
        $session = factory(Session::class)->create();

        $resp = $this->sessionRepo->delete($session->id);

        $this->assertTrue($resp);
        $this->assertNull(Session::find($session->id), 'Session should not exist in DB');
    }
}
